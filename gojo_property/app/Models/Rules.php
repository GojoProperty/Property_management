<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'content'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
