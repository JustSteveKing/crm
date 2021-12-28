<?php

declare(strict_types=1);

use App\Models\Contact;
use App\Models\Interaction;
use App\Models\User;
use Domains\Interactions\Enums\InteractionType;
use Domains\Interactions\Events\InteractionWasCreated;
use Domains\Interactions\Events\InteractionWasDeleted;
use Domains\Interactions\Events\InteractionWasUpdated;
use Domains\Interactions\Factories\InteractionFactory;
use Domains\Interactions\Handlers\InteractionHandler;

it('can store a new interaction', function (string $string) {
    $event = new InteractionWasCreated(
        object: InteractionFactory::make(
            attributes: [
                'type' => InteractionType::MEETING->value,
                'contact' => Contact::factory()->create()->id,
                'content' => $string,
                'user' => User::factory()->create()->id
            ]
        ),
    );

    expect(Interaction::query()->count())->toEqual(0);

    (new InteractionHandler())->onInteractionWasCreated(
        event: $event,
    );

    expect(Interaction::query()->count())->toEqual(1);
})->with('strings');

it('can update an interaction', function (string $string) {
    $interaction = Interaction::factory()->create();

    $event = new InteractionWasUpdated(
        interaction: $interaction->uuid,
        object: InteractionFactory::make(
            attributes: [
                'type' => InteractionType::MEETING->value,
                'contact' => Contact::factory()->create()->id,
                'content' => $string,
                'user' => User::factory()->create()->id
            ]
        ),
    );

    (new InteractionHandler())->onInteractionWasUpdated(
        event: $event,
    );

    expect($interaction->refresh())->content->toEqual($string);
})->with('strings');

it('can delete an interaction', function () {
    $interaction = Interaction::factory()->create();

    $event = new InteractionWasDeleted(
        interaction: $interaction->uuid,
    );

    expect(Interaction::query()->count())->toEqual(1);

    (new InteractionHandler())->onInteractionWasDeleted(
        event: $event,
    );

    expect(Interaction::query()->count())->toEqual(0);
});
