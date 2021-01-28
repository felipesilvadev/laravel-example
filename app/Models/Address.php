<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';

    protected $fillable = [
        'user',
        'street',
        'number',
        'city',
        'state'
    ];

    protected $hidden = [
      'user'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
