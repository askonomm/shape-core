<?php

namespace Asko\Shape\Core;

class ContentTypes
{
    private array $content_types = [];

    public function __construct()
    {
        if (!file_exists(__ROOT__ . "/src/Config/content_types.php")) {
            throw new \Exception("Please create content_types.php file in your src/Config directory");
        }

        $this->content_types = include __ROOT__ . "/src/Config/content_types.php";
    }

    public function all(): array
    {
        return $this->content_types;
    }

    public function get(string $slug): ?ContentType
    {
        foreach ($this->content_types as $content_type) {
            if ($content_type->getIdentifier() === $slug) {
                return $content_type;
            }
        }

        return null;
    }

    public function first(): ?ContentType
    {
        return $this->content_types[0] ?? null;
    }
}
