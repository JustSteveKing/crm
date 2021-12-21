<?php

declare(strict_types=1);

use App\Models\Contact;
use App\Models\Interaction;
use App\Models\InteractionStoredEvent;
use App\Models\User;
use Domains\Interactions\Enums\InteractionType;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('can get a list of interactions', function () {
    $user = User::factory()->create();
    auth()->login($user);

    Interaction::factory(10)->create(
        attributes: ['user_id' => $user->id,]
    );

    getJson(
        uri: route('api:interactions:index'),
    )->assertStatus(
        status: Http::OK,
    )->assertJson(
        value: fn(AssertableJson $json) =>
            $json->count(10)->etc(),
    );
});

it('can create a new interaction', function (string $string) {
    auth()->login(User::factory()->create());

    expect(InteractionStoredEvent::query()->count())->toEqual(0);

    postJson(
        uri: route('api:interactions:store'),
        data: [
            'type' => InteractionType::MEETING,
            'contact' => Contact::factory()->create()->id,
            'content' => $string,
        ],
    )->assertStatus(
        status: Http::ACCEPTED,
    );

    expect(InteractionStoredEvent::query()->count())->toEqual(1);
})->with('strings');

it('can show a interaction', function () {
    auth()->login(User::factory()->create());

    $interaction = Interaction::factory()->create();

    getJson(
        uri: route('api:interactions:show', $interaction->uuid),
    )->assertStatus(
        status: Http::OK,
    )->assertJson(
        value: fn(AssertableJson $json) =>
            $json->where('attributes.content', $interaction->content)->etc(),
    );
});

it('throws a Not Found status when passing an incorrect UUID', function (string $uuid) {
    auth()->login(User::factory()->create());

    getJson(
        uri: route('api:interactions:show', $uuid),
    )->assertStatus(
        status: Http::NOT_FOUND,
    );
})->with('uuids');

it('can update a interaction', function (string $string) {
    $user = User::factory()->create();
    auth()->login($user);

    $interaction = Interaction::factory()->create(
        attributes: ['user_id' => $user->id]
    );

    expect(InteractionStoredEvent::query()->count())->toEqual(0);

    putJson(
        uri: route('api:interactions:update', $interaction->uuid),
        data: [
            'type' => InteractionType::MEETING->value,
            'content' => $string,
            'contact' => $interaction->contact_id,
        ],
    )->assertStatus(
        status: Http::ACCEPTED,
    );
    expect(InteractionStoredEvent::query()->count())->toEqual(1);
})->with('strings');

it('can delete an interaction', function () {
    auth()->login(User::factory()->create());
    $interaction = Interaction::factory()->create();

    expect(InteractionStoredEvent::query()->count())->toEqual(0);

    deleteJson(
        uri: route('api:interactions:delete', $interaction->uuid),
    )->assertStatus(
        status: Http::ACCEPTED,
    );

    expect(InteractionStoredEvent::query()->count())->toEqual(1);
});

it('gets a Not Found status when interaction does not exist', function (string $uuid) {
    auth()->login(User::factory()->create());

    deleteJson(
        uri: route('api:interactions:delete', $uuid),
    )->assertStatus(
        status: Http::NOT_FOUND,
    );
})->with('uuids');
