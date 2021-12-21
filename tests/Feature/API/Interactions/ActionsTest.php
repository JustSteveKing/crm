<?php

declare(strict_types=1);

use App\Models\Interaction;
use App\Models\User;
use Domains\Interactions\Actions\CreateInteraction;
use Domains\Interactions\Actions\DeleteInteraction;
use Domains\Interactions\Actions\UpdateInteraction;
use Domains\Interactions\Factories\InteractionFactory;

it('can create a new interaction', function (string $string) {
    expect(Interaction::query()->count())->toEqual(0);

    CreateInteraction::handle(
        object: InteractionFactory::make(
            attributes: [
                'type' => \Domains\Interactions\Enums\InteractionType::PHONE->value,
                'contact' => \App\Models\Contact::factory()->create()->id,
                'user' => User::factory()->create()->id,
                'content' => $string,
            ],
        ),
    );

    expect(Interaction::query()->count())->toEqual(1);
})->with('strings');

it('can update an interaction', function (string $string) {
    $interaction = Interaction::factory()->create();

    UpdateInteraction::handle(
        interaction: $interaction->uuid,
        object: InteractionFactory::make(
            attributes: [
                'type' => $interaction->type->value,
                'contact' => $interaction->contact_id,
                'user' => $interaction->user_id,
                'content' => $string,
            ],
        )
    );

    expect($interaction->refresh())->content->toEqual($string);
})->with('strings');

it('can delete an interaction', function () {
    $interaction = Interaction::factory()->create();

    expect(Interaction::query()->count())->toEqual(1);

    DeleteInteraction::handle(
        uuid: $interaction->uuid,
    );

    expect(Interaction::query()->count())->toEqual(0);
});
