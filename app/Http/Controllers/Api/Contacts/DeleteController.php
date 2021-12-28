<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Contacts;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Domains\Contacts\Aggregates\ContactAggregateRoot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        Contact::query()->where('uuid', $uuid)->firstOrFail();

        ContactAggregateRoot::retrieve(
            uuid: $uuid,
        )->deleteContact(
            contact: $uuid,
        )->persist();

        return new JsonResponse(
            data: null,
            status: Http::ACCEPTED,
        );
    }
}
