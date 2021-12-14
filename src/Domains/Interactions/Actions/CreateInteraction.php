<?php

declare(strict_types=1);

namespace Domains\Interactions\Actions;

use App\Models\Interaction;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Contracts\ValueObjectContract;

class CreateInteraction
{
    /**
     * @param ValueObjectContract $object
     * @return Model
     */
    public static function handle(ValueObjectContract $object): Model
    {
        return Interaction::query()->create(
            attributes: $object->toArray(),
        );
    }
}
