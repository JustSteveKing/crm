<?php

declare(strict_types=1);

use App\Models\ContactStoredEvent;
use Domains\Contacts\Enums\Pronouns;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('receives a 401 on index when not logged in', function () {
    getJson(
        uri: route('api:contacts:index'),
    )->assertStatus(
        status: Http::UNAUTHORIZED,
    );
});

it('it can retrieve a list of contacts for a user', function () {
    auth()->login(User::factory()->create());

    Contact::factory(10)->create();

    getJson(
        uri: route('api:contacts:index'),
    )->assertStatus(
        status: Http::OK,
    )->assertJson(fn (AssertableJson $json) =>
        $json->count(10)
            ->first(fn (AssertableJson $json) =>
                $json->where('type', 'contact')->etc(),
            ),
    );
});

it('receives a 401 on create when not logged in', function (string $string) {
    postJson(
        uri: route('api:contacts:store'),
        data: [
            'title' => $string,
            'name' => [
                'first' => $string,
                'middle' => $string,
                'last' => $string,
                'preferred' => $string,
                'full' => "$string $string $string",
            ],
            'phone' => $string,
            'email' => "{$string}@email.com",
            'pronouns' => Pronouns::random(),
        ],
    )->assertStatus(
        status: Http::UNAUTHORIZED,
    );
})->with('strings');

it('can create a new contact', function (string $string) {
    auth()->login(User::factory()->create());

    expect(ContactStoredEvent::query()->count())->toEqual(0);

    postJson(
        uri: route('api:contacts:store'),
        data: [
            'title' => $string,
            'name' => [
                'first' => $string,
                'middle' => $string,
                'last' => $string,
                'preferred' => $string,
                'full' => "$string $string $string",
            ],
            'phone' => $string,
            'email' => "{$string}@gmail.com",
            'pronouns' => Pronouns::random(),
        ],
    )->assertStatus(
        status: Http::ACCEPTED,
    );

    expect(ContactStoredEvent::query()->count())->toEqual(1);
})->with('strings');

it('can retrieve a contact by UUID', function () {
    $contact = Contact::factory()->create();

    auth()->login(User::factory()->create());

    getJson(
        uri: route('api:contacts:show', $contact->uuid),
    )->assertStatus(
        status: Http::OK,
    )->assertJson(fn (AssertableJson $json) =>
        $json
            ->where('type', 'contact')
            ->where('attributes.name.first', $contact->first_name)
            ->where('attributes.name.last', $contact->last_name)
            ->where('attributes.phone', $contact->phone)
            ->etc(),
    );
});

it('receives a 401 on show when not logged in', function () {
    $contact = Contact::factory()->create();

    getJson(
        uri: route('api:contacts:show', $contact->uuid),
    )->assertStatus(
        status: Http::UNAUTHORIZED,
    );
});

it('receives a 404 on show with incorrect UUID', function (string $string) {
    auth()->login(User::factory()->create());
    getJson(
        uri: route('api:contacts:show', $string),
    )->assertStatus(
        status: Http::NOT_FOUND,
    );
})->with('strings');

it('can update a contact', function (string $string) {
    auth()->login(User::factory()->create());

    $contact = Contact::factory()->create();

    expect(
        ContactStoredEvent::query()->count()
    )->toEqual(0);

    expect(
        putJson(
            uri: route('api:contacts:update', $contact->uuid),
            data: [
                'title' => $string,
                'name' => [
                    'first' => $string,
                    'middle' => $string,
                    'last' => $string,
                    'preferred' => $string,
                    'full' => "$string $string $string",
                ],
                'phone' => $string,
                'email' => "{$string}@gmail.com",
                'pronouns' => Pronouns::random(),
            ]
        )
    )->assertStatus(
        status: Http::ACCEPTED,
    );

    expect(
        ContactStoredEvent::query()->count()
    )->toEqual(1);
})->with('strings');

it('returns a not found status code when trying to update a contact that doesn\'t exist', function (string $uuid) {
    auth()->login(User::factory()->create());

    expect(
        putJson(
            uri: route('api:contacts:update', $uuid),
            data: [
                'title' => 'Doctor',
                'name' => [
                'first' => $uuid,
                'middle' => $uuid,
                'last' => $uuid,
                'preferred' => $uuid,
                'full' => "$uuid",
                ],
                'phone' => $uuid,
                'email' => "{$uuid}@gmail.com",
                'pronouns' => Pronouns::random(),
            ]
        )
    )->assertStatus(
        status: Http::NOT_FOUND,
    );
})->with('uuids');

it('can delete a contact', function () {
    auth()->login(User::factory()->create());

    $contact = Contact::factory()->Create();

    expect(Contact::query()->count())->toEqual(1);

    deleteJson(
        uri: route('api:contacts:delete', $contact->uuid),
    )->assertStatus(
        status: Http::ACCEPTED,
    );

    expect(Contact::query()->count())->toEqual(0);
});
