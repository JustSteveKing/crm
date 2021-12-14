<?php

declare(strict_types=1);

namespace Domains\Interactions\Actions;

use Illuminate\Database\Eloquent\Model;
use Infrastructure\Contracts\ValueObjectContract;

class UpdateInteraction
{
    public static function handle(Model $model, ValueObjectContract $object): Model
    {
        $model->update(
            attributes: $object->toArray(),
        );

        return $model->refresh();
    }
}
