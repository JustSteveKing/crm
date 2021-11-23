<?php

declare(strict_types=1);

use App\Enums\Pronouns;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

it('gets an Unauthorized response when not logged in on the index route', function () {
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

it('can create a new contact', function (string $string) {
    auth()->login(User::factory()->create());
    expect(Contact::query()->count())->toEqual(0);
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
        status: Http::CREATED,
    )->assertJson(fn (AssertableJson $json) =>
        $json
            ->where('type', 'contact')
            ->where('attributes.name.first', $string)
            ->where('attributes.name.first', $string)
            ->where('attributes.phone', $string)
            ->etc(),
    );
    expect(Contact::query()->count())->toEqual(1);
})->with('strings');
