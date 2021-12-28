<?php

declare(strict_types=1);

namespace Domains\Interactions\Aggregates;

use Domains\Interactions\Events\InteractionWasCreated;
use Domains\Interactions\Events\InteractionWasDeleted;
use Domains\Interactions\Events\InteractionWasUpdated;
use Domains\Interactions\Repositories\InteractionStoredEventsRepository;
use Domains\Interactions\ValueObjects\InteractionValueObject;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use Spatie\EventSourcing\StoredEvents\Repositories\StoredEventRepository;

class InteractionAggregate extends AggregateRoot
{
    /**
     * @return StoredEventRepository
     */
    protected function getStoredEventRepository(): StoredEventRepository
    {
        return app(InteractionStoredEventsRepository::class);
    }

    /**
     * @param InteractionValueObject $object
     * @return $this
     */
    public function createInteraction(InteractionValueObject $object): self
    {
        $this->recordThat(
            domainEvent: new InteractionWasCreated(
                object: $object,
            ),
        );

        return $this;
    }

    /**
     * @param string $interaction
     * @param InteractionValueObject $object
     * @return $this
     */
    public function updateInteraction(string $interaction, InteractionValueObject $object): self
    {
        $this->recordThat(
            domainEvent: new InteractionWasUpdated(
                interaction: $interaction,
                object: $object,
            ),
        );

        return $this;
    }

    /**
     * @param string $interaction
     * @return $this
     */
    public function deleteInteraction(string $interaction): self
    {
        $this->recordThat(
            domainEvent: new InteractionWasDeleted(
                interaction: $interaction,
            ),
        );

        return $this;
    }
}
