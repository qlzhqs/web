<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';
    protected  $guarded = [];

    public function user()
    {
        $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
