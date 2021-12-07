<?php

declare(strict_types=1);

namespace Domains\Contacts\Handlers;

use Domains\Contacts\Actions\CreateNewContact;
use Domains\Contacts\Actions\UpdateContact;
use Domains\Contacts\Events\ContactWasCreated;
use Domains\Contacts\Events\ContactWasUpdated;
use Domains\Contacts\Exceptions\ContactUpdateException;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class ContactHandler extends Projector
{
    /**
     * @param ContactWasCreated $event
     * @return void
     */
    public function onContactWasCreated(ContactWasCreated $event): void
    {
        CreateNewContact::handle(
            object: $event->object,
        );
    }

    /**
     * @param ContactWasUpdated $event
     * @return void
     * @throws ContactUpdateException
     */
    public function onContactWasUpdated(ContactWasUpdated $event): void
    {
        UpdateContact::handle(
            uuid: $event->uuid,
            attributes: $event->object->toArray(),
        );
    }
}
