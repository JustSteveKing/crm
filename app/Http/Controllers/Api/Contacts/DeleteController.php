<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Contacts;

use App\Http\Controllers\Controller;
use App\Models\Contact;
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
        $contact = Contact::query()->where('uuid', $uuid)->firstOrFail();

        $contact->delete();

        return new JsonResponse(
            data: null,
            status: Http::ACCEPTED,
        );
    }
}
