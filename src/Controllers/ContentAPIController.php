<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Models\ContentField;
use Asko\Shape\Core\Models\ContentFieldRevisions;
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
    )
    {
        $this->guard();
    }

    public function updateField(int $content_id): Response
    {
        $revision = new ContentFieldRevisions();
        $field_identifier = array_key_first($this->request->post());
        $field_value = $this->request->post($field_identifier);
        $field = $this->content_field
            ->query()
            ->where("content_id", $content_id)
            ->where("identifier", $field_identifier)
            ->first();

        if ($field) {
            // Update existing field
            $field->value = $field_value;
            $field->save();
            $revision->content_field_id = $field->id;
        } else {
            // Create new field
            $new_field = new ContentField();
            $new_field->content_id = $content_id;
            $new_field->identifier = $field_identifier;
            $new_field->value = $field_value;
            $new_field->save();
            $revision->content_field_id = $new_field->id;
        }

        $revision->value = $field_value;
        $revision->save();

        return $this->response->json([
            "status" => "success"
        ]);
    }
}