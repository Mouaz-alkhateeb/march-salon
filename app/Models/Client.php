<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    use Notifiable;
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
