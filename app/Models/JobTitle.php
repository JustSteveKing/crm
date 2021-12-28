<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JobTitle
 *
 * @method static \Database\Factories\JobTitleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereUuid($value)
 */
class JobTitle extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'name',
    ];
}
