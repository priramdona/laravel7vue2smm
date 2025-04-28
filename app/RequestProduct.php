<?php

namespace App;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestProduct extends Model
{
    
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];
    
    protected $keyType = 'string';
    public $incrementing = false;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
    public function requestProductItems()
    {
        return $this->hasMany(RequestProductItem::class);
    }
}
