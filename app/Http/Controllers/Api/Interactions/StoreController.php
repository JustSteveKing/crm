<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Interactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Interactions\StoreRequest;
use Domains\Interactions\Aggregates\InteractionAggregate;
use Domains\Interactions\Factories\InteractionFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request): JsonResponse
    {
        InteractionAggregate::retrieve(
            uuid: Str::uuid()->toString(),
        )->createInteraction(
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
