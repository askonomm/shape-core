<?php

namespace Asko\Shape\Core\Fields;

use Asko\Shape\Core\Field;
use Asko\Shape\Core\Traits\Fieldable;
use Latte\Engine;

class MarkdownField extends Field
{
    use Fieldable;

    private ?string $placeholder = "";

    public function __construct()
    {
        $this->withInjectedJs("htmx.min", "autoresize", "markdown_upload");
    }

    public function withPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
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
