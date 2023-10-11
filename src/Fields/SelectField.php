<?php

namespace Asko\Shape\Core\Fields;

use Asko\Shape\Core\ContentField;
use Latte\Engine;

readonly class SelectField extends ContentField
{
    public function __construct(
        string $identifier,
        string $name,
        private array $options = [],
        private ?string $defaultValue = null,
    ) {
        parent::__construct(
            identifier: $identifier,
            name: $name,
            injectedJs: ["htmx.min"]
        );
    }

    public function getEditable(): callable
    {
        return function (string $content_id, string $value): string {
            $latte = new Engine();

            return $latte->renderToString(__DIR__ . "/../Views/_fields/select_editable.latte", [
                "content_id" => $content_id,
                "identifier" => $this->getIdentifier(),
                "name" => $this->getName(),
                "value" => $value === "" ? $this->defaultValue : $value,
                "options" => $this->options,
            ]);
        };
    }

    public function getViewable(): callable
    {
        return function (string $content_id, string $value): string {
            $latte = new Engine();

            return $latte->renderToString(__DIR__ . "/../Views/_fields/select_viewable.latte", [
                "content_id" => $content_id,
                "identifier" => $this->getIdentifier(),
                "name" => $this->getName(),
                "value" => $value === "" ? $this->defaultValue : $value,
            ]);
        };
    }
}
