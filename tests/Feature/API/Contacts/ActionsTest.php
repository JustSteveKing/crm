<?php

declare(strict_types=1);

use App\Models\Contact;
use Domains\Contacts\Actions\CreateNewContact;
use Domains\Contacts\Actions\UpdateContact;
use Domains\Contacts\Enums\Pronouns;
use Domains\Contacts\Exceptions\ContactUpdateException;
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

it('can update a contact', function (string $string) {
    $contact = Contact::factory()->create();

    UpdateContact::handle(
        uuid: $contact->uuid,
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
        ]
    );

    expect($contact->refresh())->phone->toEqual($string);

})->with('strings');

it('throws an exception when trying to update a contact that does not exist', function (string $uuid): void {
    UpdateContact::handle(
        uuid: $uuid,
        attributes: [
            'title' => $uuid,
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
    );
})->with('uuids')->throws(ContactUpdateException::class);
