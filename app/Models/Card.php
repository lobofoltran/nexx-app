<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use App\Services\CardService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Card extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'atcm_cards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'atcm_table_id',
        'identity',
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

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class, 'atcm_table_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'atcm_card_id');
    }

    public function orderItemQueues(): HasMany
    {
        return $this->hasMany(OrderItemQueue::class, 'atcm_card_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'atcm_card_id');
    }

    public function movimentations(): HasMany
    {
        return $this->hasMany(CardMovimentation::class, 'atcm_card_id');
    }

    public function getConsummation(): string
    {
        return CardService::getConsummation($this);
    }

    public function getPaid(): string
    {
        return CardService::getPaid($this);
    }

    public function getTime(): string
    {
        return CardService::getTime($this);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new OwnerScope);
    }
}
