<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'atcm_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'atcm_products_categories_id',
        'name',
        'description',
        'active',
        'time',
        'show_to_bar',
        'show_to_kitchen',
        'show_to_cashier',
        'image_url',
        'value',
        'cost'
    ];

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'atcm_products_categories_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'atcm_product_id');
    }

    public function productEntities(): HasMany
    {
        return $this->hasMany(ProductEntity::class, 'atcm_product_id');
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
