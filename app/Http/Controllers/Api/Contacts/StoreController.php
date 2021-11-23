<?php

namespace App\Http\Controllers\Api\Contacts;

use App\Actions\Contacts\CreateNewContact;
use App\Factories\ContactFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contacts\StoreRequest;
use App\Http\Resources\Api\ContactResource;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request): JsonResponse
    {
        return new JsonResponse(
            data: new ContactResource(
                resource: CreateNewContact::handle(
                    object: ContactFactory::make(
                        attributes: $request->validated(),
                    ),
                ),
            ),
            status: Http::CREATED,
        );
    }
}
