<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasUuids;

class Employee extends Model
{
    
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];
    
    protected $keyType = 'string';
    public $incrementing = false;

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    
    public function requestProducts()
    {
        return $this->hasMany(RequestProduct::class);
    }
}
