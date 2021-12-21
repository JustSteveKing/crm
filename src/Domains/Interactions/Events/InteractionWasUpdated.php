<?php

declare(strict_types=1);

namespace Domains\Interactions\Events;

use Domains\Interactions\ValueObjects\InteractionValueObject;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class InteractionWasUpdated extends ShouldBeStored
{
    /**
     * @param string $interaction
     * @param InteractionValueObject $object
     */
    public function __construct(
        public string $interaction,
        public InteractionValueObject $object,
    ) {}
}
