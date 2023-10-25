<?php

namespace App\Models;

use App\Models\Scopes\EnterpriseScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

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
        'owner_id',
        'atcm_table_id',
        'hash_id',
        'identity',
        'closed'
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class, 'atcm_table_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'id', 'atcm_card_id');
    }

    public function productQueues(): HasMany
    {
        return $this->hasMany(ProductQueue::class, 'id', 'atcm_card_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'id', 'atcm_card_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new EnterpriseScope);
    }
}
