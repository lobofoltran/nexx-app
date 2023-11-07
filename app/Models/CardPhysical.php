<?php

namespace App\Models;

use App\Enums\CardStatus;
use App\Models\Scopes\OwnerScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class CardPhysical extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'atcm_card_physicals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
    ];

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'atcm_card_physical_id');
    }

    public function currentCard(): Collection
    {
        return $this->cards->whereIn('status', [CardStatus::Active->value, CardStatus::Grouped->value]);
    }

    public function routeCostumer(): string
    {
        return request()->schemeAndHttpHost() . "/costumer/physical/{$this->uuid}";
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class, 'owner_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new OwnerScope);
    }
}
