<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Interactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Interactions\StoreRequest;
use App\Http\Resources\Api\InteractionResource;
use Domains\Interactions\Actions\CreateInteraction;
use Domains\Interactions\Factories\InteractionFactory;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): JsonResponse
    {
        $interaction = CreateInteraction::handle(
            object: InteractionFactory::make(
                attributes: array_merge(
                    ['user' => auth()->id()],
                    $request->validated(),
                ),
            ),
        );

        return new JsonResponse(
            data: new InteractionResource(
                resource: $interaction,
            ),
            status: Http::CREATED,
        );
    }
}
