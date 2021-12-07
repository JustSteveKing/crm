<?php

declare(strict_types=1);

use Domains\Contacts\Actions\CreateNewContact;
use Domains\Contacts\Enums\Pronouns;
use Domains\Contacts\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Model;

it('can create a new contact', function (string $string) {
    expect(
        CreateNewContact::handle(
            object: ContactFactory::make(
                attributes: [
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
            ),
        )
    )->toBeInstanceOf(Model::class)->phone->toEqual($string);
})->with('strings');
