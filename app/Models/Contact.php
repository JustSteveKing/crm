<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Contact
 *
 * @method static \Database\Factories\ContactFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|Contact onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contact withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contact withoutTrashed()
 * @property int $id
 * @property string $uuid
 * @property string|null $title
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $preferred_name
 * @property string|null $email
 * @property string|null $phone
 * @property string $pronouns
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePreferredName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePronouns($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUuid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Interaction[] $interactions
 * @property-read int|null $interactions_count
 */
class Contact extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string[]|array<int,string>
     */
    protected $fillable = [
        'uuid',
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'preferred_name',
        'email',
        'phone',
        'pronouns',
    ];

    /**
     * @return HasMany
     */
    public function interactions(): HasMany
    {
        return $this->hasMany(
            related: Interaction::class,
            foreignKey: 'contact_id',
        );
    }
}
