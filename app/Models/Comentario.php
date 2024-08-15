<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'comentario',
        'user_id',
        'post_id',
    ];

    // relation 1:n (reverse)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // relation 1:n (reverse)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
