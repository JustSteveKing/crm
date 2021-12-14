<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Interactions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\InteractionResource;
use App\Models\Interaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class ShowController extends Controller
{
    /**
     * @param Request $request
     * @param Interaction $interaction
     * @return JsonResponse
     */
    public function __invoke(Request $request, Interaction $interaction): JsonResponse
    {
        return new JsonResponse(
            data: new InteractionResource(
                resource: $interaction,
            ),
            status: Http::OK,
        );
    }
}
