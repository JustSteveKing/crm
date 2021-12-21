<?php

declare(strict_types=1);

namespace Domains\Contacts\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ContactWasDeleted extends ShouldBeStored
{
    /**
     * @param string $contact
     */
    public function __construct(
        public string $contact,
    ) {}
}
