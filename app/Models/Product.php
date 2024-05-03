<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        "product_name",
        "product_description",
        "price",
        "quantity",
        "merchant_id",
    ];

    protected $hidden = [
        "id"
    ];

    public function merchant() {
        return $this->belongsTo(Merchant::class, "merchant_id", "id");
    }
}
