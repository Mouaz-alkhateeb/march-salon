<?php

use App\Statuses\ReservationEvent;
use App\Statuses\ReservationStatus;
use App\Statuses\ReservationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->noActionOnDelete();
            $table->foreignId('expert_id')->constrained('experts')->noActionOnDelete();
            $table->dateTime('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('reservation_number')->unique();
            $table->tinyInteger('type')->default(ReservationType::UN_APPROVED);
            $table->tinyInteger('status')->default(ReservationStatus::PENDING);
            $table->float('reservation_amount', 8, 2)->nullable();
            $table->tinyInteger('payment_status')->nullable();
            $table->tinyInteger('payment_way')->nullable();
            $table->dateTime('delay_date')->nullable();
            $table->string('notes')->nullable();
            $table->string('reason_delay')->nullable();
            $table->string('reason_cancle')->nullable();
            $table->longText('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
