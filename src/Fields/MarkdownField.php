<?php

namespace Asko\Shape\Core\Fields;

use Asko\Shape\Core\ContentField;
use Latte\Engine;

readonly class MarkdownField extends ContentField
{
    public function __construct(
        string $identifier,
        string $name,
        private ?string $placeholder = null,
    ) {
        parent::__construct(
            identifier: $identifier,
            name: $name,
            injectedJs: ["htmx.min", "autoresize", "markdown_upload"]
        );
    }

    public function getEditable(): callable
    {
        return function (string $content_id, string $value): string {
            $latte = new Engine();

            return $latte->renderToString(__DIR__ . "/../Views/_fields/markdown_editable.latte", [
                "content_id" => $content_id,
                "identifier" => $this->getIdentifier(),
                "placeholder" => $this->placeholder,
                "name" => $this->getName(),
                "value" => $value,
            ]);
        };
    }

    public function getViewable(): callable
    {
        return function (string $content_id, string $value): string {
            $latte = new Engine();

            return $latte->renderToString(__DIR__ . "/../Views/_fields/markdown_viewable.latte", [
                "content_id" => $content_id,
                "identifier" => $this->getIdentifier(),
                "placeholder" => $this->placeholder,
                "name" => $this->getName(),
                "value" => $value,
            ]);
        };
    }
}
