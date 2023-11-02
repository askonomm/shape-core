<?php

namespace Asko\Shape\Core\Fields;

use Asko\Shape\Core\Field;
use Latte\Engine;
use Override;

class SelectField extends Field
{
    private array $options = [];
    private ?string $defaultValue = null;

    public function __construct(
    ) {
        $this->withInjectedJs("htmx.min");
    }

    #[Override]
    public function withIdentifier(string $identifier): self
    {
        parent::withIdentifier($identifier);

        return $this;
    }

    #[Override]
    public function withName(string $name): self
    {
        parent::withName($name);

        return $this;
    }

    public function withOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function withDefaultValue(string $defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
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
