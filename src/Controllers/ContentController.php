<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Response;
use Asko\Shape\Core\Traits\Guardable;
use Asko\Shape\Core\Models\Content;
use Asko\Shape\Core\ContentTypes;

class ContentController
{
    use Guardable;

    public function __construct(
        private ContentTypes $content_types,
    ) {
        $this->guard();
    }

    public function index(Content $content, Response $response, string $content_type): Response
    {
        return $response->viewCore("content/index", [
            "content_type" => $this->content_types->get($content_type),
            "content_items" => $content->all(),
        ]);
    }

    public function add(Response $response, string $content_type): Response
    {
        $content_id = 1235;
        return $response->redirect("/admin/content/{$content_type}/edit/{$content_id}");
    }

    /**
     * @param Content $content
     * @param Response $response
     * @param string $content_type
     * @param string $content_id
     * @return Response
     */
    public function edit(
        Content $content,
        Response $response,
        string $content_type,
        string $content_id
    ): Response {
        return $response->viewCore("content/edit", [
            "content_type" => $this->content_types->get($content_type),
            "content_item" => $content->get($content_id),
        ]);
    }
}
