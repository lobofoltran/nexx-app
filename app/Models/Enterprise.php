<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
}
