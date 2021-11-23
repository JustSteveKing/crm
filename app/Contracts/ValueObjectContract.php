<?php

declare(strict_types=1);

namespace App\Contracts;

interface ValueObjectContract
{
    /**
     * @return array
     */
    public function toArray(): array;
}
