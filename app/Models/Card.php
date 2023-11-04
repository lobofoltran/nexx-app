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

class Card extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

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

    public function cardPhysical(): BelongsTo
    {
        return $this->belongsTo(CardPhysical::class, 'atcm_card_physical_id');
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

    public function groupments(): HasMany
    {
        return $this->hasMany(GroupCard::class, 'atcm_card_id');
    }

    public function routeCostumer(): string
    {
        return request()->schemeAndHttpHost() . "/client/virtual/{$this->uuid}";
    }

    public function getConsummation(): string
    {
        return CardService::getConsummation($this);
    }

    public function getPaid(): string
    {
        return CardService::getPaid($this);
    }

    public function getTransshipment(): string
    {
        return CardService::getTransshipment($this);
    }

    public function getMissing(): string
    {
        return CardService::getMissing($this);
    }

    public function getConsummationTotal(): string
    {
        return CardService::getConsummation($this, true);
    }

    public function getPaidTotal(): string
    {
        return CardService::getPaid($this, true);
    }

    public function getTransshipmentTotal(): string
    {
        return CardService::getTransshipment($this, true);
    }

    public function getMissingTotal(): string
    {
        return CardService::getMissing($this, true);
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
