<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Models\ContentField;
use Asko\Shape\Core\Request;
use Asko\Shape\Core\Response;
use Asko\Shape\Core\Traits\Guardable;

class ContentAPIController
{
    use Guardable;

    public function __construct(
        private readonly Request      $request,
        private readonly Response     $response,
        private readonly ContentField $content_field,
    ) {
        $this->guard();
    }

    public function updateField(int $content_id): Response
    {
        $field_identifier = array_key_first($this->request->post());
        $field_value = $this->request->post($field_identifier);
        $field = $this->content_field
            ->query()
            ->where("content_id", $content_id)
            ->where("identifier", $field_identifier)
            ->first();

        if ($field) {
            $field->value = $field_value;
            $field->save();
        } else {
            $new_field = new ContentField();
            $new_field->content_id = $content_id;
            $new_field->identifier = $field_identifier;
            $new_field->value = $field_value;
            $new_field->save();
        }

        return $this->response->json([
            "status" => "success"
        ]);
    }
}