<?php

declare(strict_types=1);

namespace Domains\Interactions\Actions;

use App\Models\Interaction;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Contracts\ValueObjectContract;

class UpdateInteraction
{
    public static function handle(string $interaction, ValueObjectContract $object): Model
    {
        $model = Interaction::query()->where('uuid', $interaction)->firstOrFail();

        $model->update(
            attributes: $object->toArray(),
        );

        return $model->refresh();
    }
}
