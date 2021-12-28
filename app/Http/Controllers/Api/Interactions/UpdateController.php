<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Interactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Interactions\UpdateRequest;
use App\Models\Interaction;
use Domains\Interactions\Aggregates\InteractionAggregate;
use Domains\Interactions\Factories\InteractionFactory;
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
        Interaction::query()->where('uuid', $uuid)->firstOrFail();

        InteractionAggregate::retrieve(
            uuid: $uuid,
        )->updateInteraction(
            interaction: $uuid,
            object: InteractionFactory::make(
                attributes: array_merge(
                    ['user' => auth()->id()],
                    $request->validated(),
                ),
            )
        )->persist();

        return new JsonResponse(
            data: null,
            status: Http::ACCEPTED,
        );
    }
}
