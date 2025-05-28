<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentRating extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'agent_id', 'rating', 'comment'];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(AgentRating::class, 'agent_id');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

}
