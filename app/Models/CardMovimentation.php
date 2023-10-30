<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardMovimentation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'atcm_card_movimentations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'atcm_card_id', 'model_type', 'model_id', 'action', 'details',
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'atcm_card_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
