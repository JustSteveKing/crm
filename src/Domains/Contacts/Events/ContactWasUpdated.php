<?php

declare(strict_types=1);

namespace Domains\Contacts\Events;

use Domains\Contacts\ValueObjects\ContactValueObject;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

final class ContactWasUpdated extends ShouldBeStored
{
    /**
     * @param ContactValueObject $object
     * @param string $uuid
     */
    public function __construct(
        public ContactValueObject $object,
        public string $uuid,
    ) {}
}
