<?php

declare(strict_types=1);

namespace App\Providers;

use Domains\Contacts\Handlers\ContactHandler;
use Domains\Interactions\Handlers\InteractionHandler;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        Projectionist::addProjector(
            projector: ContactHandler::class,
        );

        Projectionist::addProjector(
            projector: InteractionHandler::class,
        );
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
