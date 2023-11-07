<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use App\Services\OrderItemService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'atcm_order_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'atcm_order_id',
        'atcm_product_id',
        'observations',
        'value',
        'cost',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'atcm_order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'atcm_product_id');
    }

    public function orderItemQueue(): HasOne
    {
        return $this->hasOne(OrderItemQueue::class, 'atcm_order_item_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new OwnerScope);
    }
}
