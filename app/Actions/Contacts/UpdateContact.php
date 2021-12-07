<?php

declare(strict_types=1);

namespace App\Actions\Contacts;

use App\Models\Contact;

final class UpdateContact
{
    /**
     * @param Contact $contact
     * @param array $attributes
     */
    public static function handle(Contact $contact, array $attributes): void
    {
        $contact->update(
            attributes: $attributes,
        );
    }
}
