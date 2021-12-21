<?php

declare(strict_types=1);

namespace Domains\Contacts\Actions;

use App\Models\Contact;

class DeleteContact
{
    /**
     * @param string $contact
     * @return void
     */
    public static function handle(string $contact): void
    {
        $model = Contact::query()->where('uuid', $contact)->firstOrFail();

        $model->delete();
    }
}
