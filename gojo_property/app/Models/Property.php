<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'ptype_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }
    public function multiImages()
    {
        return $this->hasMany(MultiImage::class, 'property_id');
    }
    public function facilities()
    {
        return $this->hasMany(Facility::class, 'property_id');
    }
    public function pstate()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }
    public function rules()
    {
        return $this->hasMany(Rules::class);
    }
}
