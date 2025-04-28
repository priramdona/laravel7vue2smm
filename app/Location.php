<?php

namespace App;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];
    
    protected $keyType = 'string';
    public $incrementing = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
