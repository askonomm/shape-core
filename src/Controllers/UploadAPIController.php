<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Response;

class UploadAPIController
{
    public function uploadImage(Response $response): Response
    {
        $upload_path = env("UPLOAD_PATH");
        $upload_url = env("UPLOAD_URL");

        if (!$upload_path || !$upload_url) {
            return $response->json([
                "status" => "failure",
                "message" => "UPLOAD_PATH or UPLOAD_URL environment variable not set.",
            ]);
        }

        return $response->json([
            "status" => "success",
            "file_url" => "asd"
        ]);
    }
}