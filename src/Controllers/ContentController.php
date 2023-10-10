<?php

namespace Asko\Shape\Core\Controllers;

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

    /**
     * @param ContentTypes $content_types
     * @param Content $content
     * @param ContentField $content_field
     * @param Response $response
     */
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
        return $response->viewCore("content/index", [
            "content_type" => $this->content_types->get($content_type),
            "content_types" => $this->content_types->all(),
            "content_items" => $content->where("identifier", $content_type)->get(),
        ]);
    }

    /**
     * @param string $content_type
     * @return Response
     */
    public function add(string $content_type): Response
    {
        $content = new Content();
        $content->identifier = $content_type;
        $content->save();

        return $response->redirect("/admin/content/{$content_type}/edit/{$content->id}");
    }

    /**
     * @param string $content_type
     * @param string $content_id
     * @return Response
     */
    public function edit(string $content_type, string $content_id): Response {
        $fields = [];

        foreach ($this->content_types->get($content_type)->getFields() as $field) {
            $field_id = $field->getIdentifier();
            $field_value = $content_field->where("identifier", $field_id)->first()?->value ?? "";
            $fields[] = [
                'identifier' => $field->getIdentifier(),
                'name' => $field->getName(),
                'editable' => $field->getEditable()($content_id, $field_value),
            ];
        }

        return $response->viewCore("content/edit", [
            "content_type" => $this->content_types->get($content_type),
            "content_types" => $this->content_types->all(),
            "content_item" => $content->get($content_id),
            "fields" => $fields,
        ]);
    }
}
