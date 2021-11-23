<?php

namespace App\Http\Controllers\Api\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $contact = QueryBuilder::for(
            subject: Contact::class,
        )->where('uuid', $uuid)->firstOrFail();

        return new JsonResponse(
            data: new ContactResource(
                resource: $contact,
            ),
            status: Http::OK,
        );
    }
}
