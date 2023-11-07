<?php

namespace App\Models;

use App\Models\Scopes\OwnerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogsQrCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'atcm_logs_qrcode';


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
