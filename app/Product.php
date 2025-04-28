<?php

namespace App;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];
    
    protected $keyType = 'string';
    public $incrementing = false;

    
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function requestProductItems()
    {
        return $this->hasMany(RequestProductItem::class);
    }
}
