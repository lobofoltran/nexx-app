<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductEntity extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'atcm_product_entities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'atcm_product_id',
        'name',
        'active',
        'status'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'atcm_product_id');
    }

    public function movimentations(): HasMany
    {
        return $this->hasMany(ProductEntityMovimentation::class, 'atcm_product_entity_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new OwnerScope);
    }

}
