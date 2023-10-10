<?php

namespace Asko\Shape\Core\Fields;

use Asko\Shape\Core\ContentField;

readonly class TextField extends ContentField
{
    public function __construct(
        private string $identifier,
        private string $name,
        private ?string $placeholder = null,
        private ?string $prefix = null,
        private ?string $suffix = null,
    ) {
        parent::__construct(
            identifier: $identifier,
            name: $name,
        );
    }

    public function getEditable(): callable
    {
        return function (string $content_id, string $value): string {
            $latte = new \Latte\Engine();

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
            $latte = new \Latte\Engine();

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
