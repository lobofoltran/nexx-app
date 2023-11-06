<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enterprise extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'active',
        'free_to_pay'
    ];

    /**
     * The users that belong to the enterprise.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(EnterpriseUser::class);
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class, 'owner_id');
    }

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class, 'owner_id');
    }

    public function cardPhysicals(): HasMany
    {
        return $this->hasMany(CardPhysical::class, 'owner_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'owner_id');
    }

    public function productCategories(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'owner_id');
    }

    public function productEntities(): HasMany
    {
        return $this->hasMany(ProductEntity::class, 'owner_id');
    }
}
