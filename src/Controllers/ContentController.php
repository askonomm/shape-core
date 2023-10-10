<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Core;
use Asko\Shape\Core\Response;
use Asko\Shape\Core\Traits\Guardable;
use Asko\Shape\Core\Models\Content;
use Asko\Shape\Core\Models\ContentField;
use Asko\Shape\Core\ContentTypes;

/**
 *
 */
class ContentController
{
    use Guardable;

    public function __construct(
        private ContentTypes $content_types,
        private Content $content,
        private ContentField $content_field,
        private Response $response,
    ) {
        $this->guard();
    }

    /**
     * @param string $content_type
     * @return Response
     */
    public function index(string $content_type): Response
    {
        return $this->response->viewCore("content/index", [
            "content_type" => $this->content_types->get($content_type),
            "content_types" => $this->content_types->all(),
            "content_items" => $this->content->where("identifier", $content_type)->get(),
            "shape_version" => Core::version(),
        ]);
    }

    /**
     * @param string $content_type
     * @return Response
     */
    public function add(string $content_type): Response
    {
        $this->content = new Content();
        $this->content->identifier = $content_type;
        $this->content->save();

        return $this->response->redirect("/admin/content/{$content_type}/edit/{$this->content->id}");
    }

    /**
     * @param string $content_type
     * @param string $content_id
     * @return Response
     */
    public function edit(string $content_type, int $content_id): Response {
        // Compute fields
        $fields = [];

        foreach ($this->content_types->get($content_type)->getFields() as $field) {
            $field_id = $field->getIdentifier();
            $field_value = $this->content_field->where("identifier", $field_id)->first()?->value ?? "";
            $fields[] = [
                'identifier' => $field->getIdentifier(),
                'name' => $field->getName(),
                'editable' => $field->getEditable()($content_id, $field_value),
            ];
        }
        
        // Compute injections
        $css_injections = [];
        $js_injections = [];

        foreach($this->content_types->get($content_type)->getFields() as $field) {
            foreach($field->getInjectedCss() as $css) {
                if (!in_array($css, $css_injections)) {
                    $css_injections[] = $css;
                }
            }

            foreach($field->getInjectedJs() as $js) {
                if (!in_array($js, $js_injections)) {
                    $js_injections[] = $js;
                }
            }
        }

        return $this->response->viewCore("content/edit", [
            "content_type" => $this->content_types->get($content_type),
            "content_types" => $this->content_types->all(),
            "content_item" => $this->content->get($content_id),
            "fields" => $fields,
            "js_injections" => $js_injections,
            "css_injections" => $css_injections,
            "shape_version" => Core::version(),
        ]);
    }
}
