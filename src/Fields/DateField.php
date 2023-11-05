<?php

namespace Asko\Shape\Core\Fields;

use Asko\Shape\Core\Field;
use Asko\Shape\Core\Traits\Fieldable;
use Latte\Engine;

class DateField extends Field
{
    use Fieldable;

    public function __construct()
    {
        $this->withInjectedJs("htmx.min");
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
