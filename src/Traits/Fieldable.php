<?php

namespace Asko\Shape\Core\Traits;

use Override;

trait Fieldable
{
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
}
