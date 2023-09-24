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

    public function render(string $template, array $params = []): void
    {
        if (!defined("__ROOT__")) {
            throw new \Exception("Please define __ROOT__ constant in your public/index.php file");
        }

        $templateLocation = __ROOT__ . "/src/Views/" . $template;

        if ($this->rootDir) {
            $templateLocation = $this->rootDir . "/" . $template;
        }

        $this->latte->render($templateLocation, $params);
    }
}
