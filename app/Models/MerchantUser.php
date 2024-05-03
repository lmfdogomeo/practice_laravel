<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantUser extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        "uuid",
        "merchant_id",
        "user_id",
    ];

    protected $hidden = [
        'id',
    ];

    public function merchant() {
        return $this->belongsTo(Merchant::class, "merchant_id", "id");
    }

    public function user() {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
