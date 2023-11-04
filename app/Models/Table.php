<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use App\Services\TableService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'atcm_tables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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

    public function routeCostumer(): string
    {
        return request()->schemeAndHttpHost() . "/client/table/{$this->uuid}";
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'atcm_table_id');
    }

    public function movimentations(): HasMany
    {
        return $this->hasMany(TableMovimentation::class, 'atcm_table_id');
    }

    public function groupments(): HasMany
    {
        return $this->hasMany(GroupTable::class, 'atcm_table_id');
    }

    public function getConsummation(): string
    {
        return TableService::getConsummation($this);
    }

    public function getTime(): string
    {
        return TableService::getTime($this);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new OwnerScope);
    }
}
