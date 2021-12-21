<?php

declare(strict_types=1);

namespace Domains\Interactions\Repositories;

use App\Models\InteractionStoredEvent;
use Spatie\EventSourcing\AggregateRoots\Exceptions\InvalidEloquentStoredEventModel;
use Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository;

class InteractionStoredEventsRepository extends EloquentStoredEventRepository
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

        $this->storedEventModel = InteractionStoredEvent::class;
    }
}
