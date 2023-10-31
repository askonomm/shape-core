<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Core;
use Asko\Shape\Core\Response;
use Asko\Shape\Core\Services\ContentService;
use Asko\Shape\Core\Traits\Guardable;
use Asko\Shape\Core\Models\Content;
use Asko\Shape\Core\Models\ContentFields;
use Asko\Shape\Core\ContentTypes;

/**
 *
 */
class ContentController
{
    use Guardable;

    public function __construct(
        private readonly ContentTypes $content_types,
        private readonly Content $content,
        private readonly ContentFields $content_field,
        private readonly Response $response,
    ) {
        $this->guard();
    }

    /**
     * @param string $content_type
     * @return Response
     */
    public function index(ContentService $content_service, string $content_type): Response
    {
        $content_items = [];
        $list_view_sort_by =  $this->content_types->get($content_type)->getListViewSortBy();
        $list_view_order = $this->content_types->get($content_type)->getListViewOrder();
        $list_view_items = [];

        if (!$list_view_sort_by) {
            $list_view_items = $content_service
                ->query($content_type)
                ->attachFields()
                ->get();
        }

        if ($list_view_sort_by && (!$list_view_order || $list_view_order === "desc")) {
            $list_view_items = $content_service
                ->query($content_type, $list_view_sort_by)
                ->attachFields()
                ->get();
        }

        if ($list_view_sort_by && $list_view_order === "asc") {
            $list_view_items = $content_service
                ->query($content_type, $list_view_sort_by, $list_view_order)
                ->attachFields()
                ->get();
        }

        foreach($list_view_items as $item) {
            // Compute fields
            $fields = [];
            $list_view_fields = $this->content_types->get($content_type)->getListViewFields();

            foreach ($this->content_types->get($content_type)->getFields() as $field) {

                $field_value = array_filter($item->fields->toArray(), function(array $f) use($field) {
                    return $f['identifier'] === $field->getIdentifier();
                })[0]['value'] ?? "";

                $fields[$field->getIdentifier()] = [
                    'name' => $field->getName(),
                    'viewable' => $field->getViewable()($item->id, $field_value),
                    "value" => $field_value,
                    "visible" => in_array($field->getIdentifier(), $list_view_fields),
                ];
            }

            $computed_list_view_fields = [];

            foreach($list_view_fields as $field) {
                $computed_list_view_fields[] = $fields[$field];
            }

            // Construct items
            $content_items[] = [
                "data" => $item,
                "fields" => $fields,
                "list_view_fields" => $computed_list_view_fields,
            ];
        }

        return $this->response->viewCore("content/index", [
            "content_type" => $this->content_types->get($content_type),
            "content_types" => $this->content_types->all(),
            "content_items" => $content_items,
            "total_results" => count($content_items),
            "shape_version" => Core::version(),
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

        return $this->response->redirect("/admin/content/{$content_type}/edit/{$content->id}");
    }

    /**
     * @param string $content_type
     * @param int $content_id
     * @return Response
     */
    public function edit(string $content_type, int $content_id): Response {
        // Compute fields
        $fields = [];

        foreach ($this->content_types->get($content_type)->getFields() as $field) {
            $field_id = $field->getIdentifier();
            $field_value = $this->content_field
                ->where("content_id", $content_id)
                ->where("identifier", $field_id)
                ->first()?->value ?? "";

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
