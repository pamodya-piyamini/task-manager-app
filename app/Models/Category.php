<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    // A category belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A category can have many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}
