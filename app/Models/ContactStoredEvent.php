<?php

declare(strict_types=1);

namespace App\Models;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class ContactStoredEvent extends EloquentStoredEvent
{
    /**
     * @var string
     */
    protected $table = 'contact_stored_events';
}
