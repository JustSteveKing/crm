<?php

declare(strict_types=1);

namespace Domains\Contacts\Repositories;

use App\Models\ContactStoredEvent;
use Spatie\EventSourcing\AggregateRoots\Exceptions\InvalidEloquentStoredEventModel;
use Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository;

class ContactStoredEventsRepository extends EloquentStoredEventRepository
{
    /**
     * @var string
     */
    protected string $storedEventModel;

    /**
     * @throws InvalidEloquentStoredEventModel
     */
    public function __construct() {
        parent::__construct();

        $this->storedEventModel = ContactStoredEvent::class;
    }
}
