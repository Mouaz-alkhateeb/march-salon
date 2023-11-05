<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationHistory extends Model
{
    use HasFactory;
    protected $table = 'reservation_histories';

    protected $fillable = ['reservation_id', 'expert_id', 'client_id', 'is_confirmed', 'date', 'start_time', 'end_time', 'arrive_time', 'arrive_date', 'status'];


    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
    public function expert()
    {
        return $this->belongsTo(Expert::class, 'expert_id');
    }
}
