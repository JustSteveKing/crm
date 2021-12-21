<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Interactions;

use App\Http\Controllers\Controller;
use App\Models\Interaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class DeleteController extends Controller
{
    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $interaction = Interaction::query()->where('uuid', $uuid)->firstOrFail();

        $interaction->delete();

        return new JsonResponse(
            data: null,
            status: Http::ACCEPTED,
        );
    }
}
