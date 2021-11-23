<?php

declare(strict_types=1);

use App\Models\Contact;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;

use function Pest\Laravel\getJson;

it('it can retrieve a list of contacts for a user', function () {
    auth()->loginUsingId(User::factory()->create()->id);

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
