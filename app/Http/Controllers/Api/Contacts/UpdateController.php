<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Contacts;

use App\Actions\Contacts\UpdateContact;
use App\Factories\ContactFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contacts\UpdateRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

class UpdateController extends Controller
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

        $valueObject = ContactFactory::make(
            attributes: $request->validated(),
        );

        UpdateContact::handle(
            contact: $contact,
            attributes: $valueObject->toArray(),
        );

        return new JsonResponse(
            data: $contact->refresh(),
            status: Http::ACCEPTED,
        );
    }
}
