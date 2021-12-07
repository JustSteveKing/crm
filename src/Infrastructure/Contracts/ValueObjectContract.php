<?php

declare(strict_types=1);

namespace Infrastructure\Contracts;

interface ValueObjectContract
{
    /**
     * @return array
     */
    public function toArray(): array;
}
