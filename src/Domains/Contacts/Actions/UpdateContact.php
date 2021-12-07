<?php

declare(strict_types=1);

namespace Domains\Contacts\Actions;

use App\Models\Contact;
use Domains\Contacts\Exceptions\ContactUpdateException;
use Throwable;

final class UpdateContact
{
    /**
     * @param string $uuid
     * @param array $attributes
     * @return void
     * @throws ContactUpdateException
     */
    public static function handle(string $uuid, array $attributes): void
    {
        try {
            $contact = Contact::query()->where('uuid', $uuid)->firstOrFail();

            $contact->updateOrFail(
                attributes: $attributes,
            );
        } catch (Throwable $exception) {
            throw new ContactUpdateException(
                message: "Failed to update a contact with UUID [$uuid]",
                previous: $exception,
            );
        }
    }
}
