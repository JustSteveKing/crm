<?php

declare(strict_types=1);

namespace App\Models;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class InteractionStoredEvent extends EloquentStoredEvent
{
    /**
     * @var string
     */
    protected $table = 'interaction_stored_events';
}
