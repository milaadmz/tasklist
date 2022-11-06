<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];


    public function share()
    {
        return $this->morphMany(Share::class, 'shareable');
    }
}
