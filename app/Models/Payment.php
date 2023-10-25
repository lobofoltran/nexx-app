<?php

namespace App\Models;

use App\Models\Scopes\EnterpriseScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'atcm_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'atcm_card_id',
        'atcm_payment_method_id',
        'transshipment',
        'value'
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'atcm_card_id', 'id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'atcm_payment_method_id', 'id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new EnterpriseScope);
    }

}
