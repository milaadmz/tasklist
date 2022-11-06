<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $fillable = [
        'shareable_id',
        'shareable_type',
        'task_id',
    ];

    public function shareable()
    {
        return $this->morphedByMany(User::class, 'shareable');
    }
}
