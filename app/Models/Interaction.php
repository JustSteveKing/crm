<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Interaction
 *
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property string|null $content
 * @property int $contact_id
 * @property int|null $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\InteractionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction whereUuid($value)
 * @mixin \Eloquent
 * @property int|null $user_id
 * @property-read \App\Models\Contact $contact
 * @property-read \App\Models\User|null $owner
 * @property-read \App\Models\Project|null $project
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction whereUserId($value)
 */
class Interaction extends Model
{
    use HasUuid;
    use HasFactory;

    /**
     * @var string[]|array<int,string>
     */
    protected $fillable = [
        'uuid',
        'type',
        'content',
        'user_id',
        'contact_id',
        'project_id',
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    /**
     * @return BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(
            related: Contact::class,
            foreignKey: 'contact_id',
        );
    }

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(
            related: Project::class,
            foreignKey: 'project_id',
        );
    }
}
