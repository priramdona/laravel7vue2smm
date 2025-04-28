<?php

namespace App;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestProductItem extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];
    
    protected $keyType = 'string';
    public $incrementing = false;
    
    public function requestProduct()
    {
        return $this->belongsTo(RequestProduct::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
