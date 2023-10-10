<?php

namespace Asko\Shape\Core\Interfaces;

interface ContentFieldInterface
{
    public function __construct(
        string $identifier,
        string $name,
    );

    public function getIdentifier(): string;
    public function getName(): string;
    public function getInjectedCss(): array;
    public function getInjectedJs(): array;
    public function getEditable(): callable;
    public function getViewable(): callable;
}
