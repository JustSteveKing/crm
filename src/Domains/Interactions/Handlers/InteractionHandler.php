<?php

declare(strict_types=1);

namespace Domains\Interactions\Handlers;

use Domains\Interactions\Actions\CreateInteraction;
use Domains\Interactions\Actions\DeleteInteraction;
use Domains\Interactions\Actions\UpdateInteraction;
use Domains\Interactions\Events\InteractionWasCreated;
use Domains\Interactions\Events\InteractionWasDeleted;
use Domains\Interactions\Events\InteractionWasUpdated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class InteractionHandler extends Projector
{
    /**
     * @param InteractionWasCreated $event
     * @return void
     */
    public function onInteractionWasCreated(InteractionWasCreated $event): void
    {
        CreateInteraction::handle(
            object: $event->object,
        );
    }

    public function onInteractionWasUpdated(InteractionWasUpdated $event): void
    {
        UpdateInteraction::handle(
            interaction: $event->interaction,
            object: $event->object,
        );
    }

    /**
     * @param InteractionWasDeleted $event
     * @return void
     */
    public function onInteractionWasDeleted(InteractionWasDeleted $event): void
    {
        DeleteInteraction::handle(
            uuid: $event->interaction,
        );
    }
}
