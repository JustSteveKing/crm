<?php

declare(strict_types=1);

namespace Domains\Contacts\Aggregates;

use Domains\Contacts\Events\ContactWasCreated;
use Domains\Contacts\Events\ContactWasDeleted;
use Domains\Contacts\Events\ContactWasUpdated;
use Domains\Contacts\ValueObjects\ContactValueObject;
use Domains\Contacts\Repositories\ContactStoredEventsRepository;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use Spatie\EventSourcing\StoredEvents\Repositories\StoredEventRepository;

final class ContactAggregateRoot extends AggregateRoot
{
    /**
     * @return StoredEventRepository
     */
    protected function getStoredEventRepository(): StoredEventRepository
    {
        return app(ContactStoredEventsRepository::class);
    }

    /**
     * @param ContactValueObject $object
     * @return $this
     */
    public function createContact(ContactValueObject $object): self
    {
        $this->recordThat(
            domainEvent: new ContactWasCreated(
                object: $object,
            ),
        );

        return $this;
    }

    /**
     * @param ContactValueObject $object
     * @param string $uuid
     * @return $this
     */
    public function updateContact(ContactValueObject $object, string $uuid): self
    {
        $this->recordThat(
            domainEvent: new ContactWasUpdated(
                object: $object,
                uuid: $uuid,
            ),
        );

        return $this;
    }

    /**
     * @param string $contact
     * @return $this
     */
    public function deleteContact(string $contact): self
    {
        $this->recordThat(
            domainEvent: new ContactWasDeleted(
                contact: $contact,
            ),
        );

        return $this;
    }
}
