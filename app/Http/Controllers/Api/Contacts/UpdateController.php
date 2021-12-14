<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Contacts;

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
     * @param Contact $contact
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Contact $contact): JsonResponse
    {
        ContactAggregateRoot::retrieve(
            uuid: $contact->uuid,
        )->updateContact(
            object: ContactFactory::make(
                attributes: $request->validated(),
            ),
            uuid: $contact->uuid,
        )->persist();

        return new JsonResponse(
            data: null,
            status: Http::ACCEPTED,
        );
    }
}
