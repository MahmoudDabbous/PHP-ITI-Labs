<?php

namespace Dabbous\Store\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        "product_code",
        "product_name",
        "Photo",
        "list_price",
        "reorder_level",
        "units_in_stock",
        "category",
        "country",
        "rating",
        "discontinued",
        "date",
    ];
}
