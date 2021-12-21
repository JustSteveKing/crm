<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Interactions;

use App\Http\Controllers\Controller;
use App\Models\Interaction;
use Domains\Interactions\Aggregates\InteractionAggregate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class DeleteController extends Controller
{
    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        Interaction::query()->where('uuid', $uuid)->firstOrFail();

        InteractionAggregate::retrieve(
            uuid: $uuid,
        )->deleteInteraction(
            interaction: $uuid,
        )->persist();

        return new JsonResponse(
            data: null,
            status: Http::ACCEPTED,
        );
    }
}
