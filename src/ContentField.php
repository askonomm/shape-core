<?php

namespace Asko\Shape\Core;

use Asko\Shape\Core\Interfaces\ContentFieldInterface;

class ContentField
{
    private string $identifier;
    private string $name;
    private array $injectedJs = [];
    private array $injectedCss = [];

    public function withIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withInjectedJs(string ...$js): self
    {
        $this->injectedJs = $js;

        return $this;
    }

    public function withInjectedCss(string ...$css): self
    {
        $this->injectedCss = $css;

        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInjectedJs(): array
    {
        return $this->injectedJs;
    }

    public function getInjectedCss(): array
    {
        return $this->injectedCss;
    }

    public function getEditable(): callable
    {
        return function (string $content_id, string $value): string {
            return $value;
        };
    }

    public function getViewable(): callable
    {
        return function (string $content_id, string $value): string {
            return $value;
        };
    }
}
