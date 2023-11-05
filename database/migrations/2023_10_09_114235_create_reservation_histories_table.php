<?php

use App\Statuses\ConfirmedType;
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
        Schema::create('reservation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->noActionOnDelete();
            $table->foreignId('expert_id')->constrained('experts')->noActionOnDelete();
            $table->foreignId('client_id')->constrained('clients')->noActionOnDelete();
            $table->tinyInteger('is_confirmed');
            $table->dateTime('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->date('arrive_date')->nullable();
            $table->time('arrive_time')->nullable();
            $table->tinyInteger('status');

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
        Schema::dropIfExists('reservation_histories');
    }
};
