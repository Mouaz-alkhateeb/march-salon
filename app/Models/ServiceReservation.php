<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReservation extends Model
{
    use HasFactory;
    protected $table = 'service_reservations';
    protected $fillable = ['reservation_id', 'service_id'];
}
