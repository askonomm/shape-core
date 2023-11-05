<?php

namespace Asko\Shape\Core\Fields;

use Asko\Shape\Core\Field;
use Asko\Shape\Core\Traits\Fieldable;
use Latte\Engine;

class TextField extends Field
{
    use Fieldable;

    private ?string $placeholder = null;
    private ?string $prefix = null;
    private ?string $suffix = null;

    public function __construct()
    {
        $this->withInjectedJs("htmx.min");
    }

    public function withPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function withPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function withSuffix(string $suffix): self
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function getEditable(): callable
    {
        return function (string $content_id, string $value): string {
            $latte = new Engine();

            return $latte->renderToString(__DIR__ . "/../Views/_fields/text_editable.latte", [
                "content_id" => $content_id,
                "prefix" => $this->prefix,
                "suffix" => $this->suffix,
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

            return $latte->renderToString(__DIR__ . "/../Views/_fields/text_viewable.latte", [
                "content_id" => $content_id,
                "prefix" => $this->prefix,
                "suffix" => $this->suffix,
                "identifier" => $this->getIdentifier(),
                "placeholder" => $this->placeholder,
                "name" => $this->getName(),
                "value" => $value,
            ]);
        };
    }
}
