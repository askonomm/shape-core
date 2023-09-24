<?php

namespace Asko\Shape\Core;

use Latte\Engine;

class View
{
    private Engine $latte;

    public function __construct(private ?string $rootDir = null)
    {
        $this->latte = new Engine();
    }

    public function render(string $template, array $params = []): string
    {
        if (!defined("__ROOT__")) {
            define("__ROOT__", __DIR__);
        }

        $templateLocation = __ROOT__ . "/src/Views/" . $template;

        if ($this->rootDir) {
            $templateLocation = $this->rootDir . "/" . $template;
        }

        try {
            return $this->latte->renderToString($templateLocation . ".latte", $params);
        } catch (\Exception) {
            return "";
        }
    }
}
