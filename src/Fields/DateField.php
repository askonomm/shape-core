<?php

namespace Asko\Shape\Core\Fields;

use Asko\Shape\Core\Field;
use Latte\Engine;
use Override;

class DateField extends Field
{
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

    public function getEditable(): callable
    {
        return function (string $content_id, string $value): string {
            $latte = new Engine();

            return $latte->renderToString(__DIR__ . "/../Views/_fields/date_editable.latte", [
                "content_id" => $content_id,
                "identifier" => $this->getIdentifier(),
                "name" => $this->getName(),
                "value" => $value,
            ]);
        };
    }

    public function getViewable(): callable
    {
        return function (string $content_id, string $value): string {
            $latte = new Engine();

            return $latte->renderToString(__DIR__ . "/../Views/_fields/date_viewable.latte", [
                "content_id" => $content_id,
                "identifier" => $this->getIdentifier(),
                "name" => $this->getName(),
                "value" => $value,
            ]);
        };
    }
}
