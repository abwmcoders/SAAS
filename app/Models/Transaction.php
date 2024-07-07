<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'price',
        'credits',
        'session_id',
        'package_id',
        'user_id',
    ];

    public function user() {
        return $this->BelongsTo(User::class);
    }
}
