<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationEvent extends Model
{
    use HasFactory;
    protected $table = 'reservation_events';
    protected $fillable = ['reservation_id', 'event_id'];
}
