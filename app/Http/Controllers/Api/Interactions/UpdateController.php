<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Interactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Interactions\UpdateRequest;
use App\Http\Resources\Api\InteractionResource;
use App\Models\Interaction;
use Domains\Interactions\Actions\UpdateInteraction;
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
        $interaction = Interaction::query()->where('uuid', $uuid)->firstOrFail();

        $interaction = UpdateInteraction::handle(
            model: $interaction,
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
            status: Http::ACCEPTED,
        );
    }
}
