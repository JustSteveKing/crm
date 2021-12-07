<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Contacts;

use Domains\Contacts\Actions\UpdateContact;
use Domains\Contacts\Aggregates\ContactAggregateRoot;
use Domains\Contacts\Factories\ContactFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contacts\UpdateRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

final class UpdateController extends Controller
{
    /**
     * @param UpdateRequest $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, string $uuid): JsonResponse
    {
        $contact = Contact::query()
            ->where('uuid', $uuid)
            ->firstOrFail();

        ContactAggregateRoot::retrieve(
            uuid: $uuid,
        )->updateContact(
            object: ContactFactory::make(
                attributes: $request->validated(),
            ),
            uuid: $uuid,
        )->persist();

        return new JsonResponse(
            data: null,
            status: Http::ACCEPTED,
        );
    }
}
