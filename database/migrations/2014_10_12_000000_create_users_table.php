<?php

use App\Statuses\HavePermission;
use App\Statuses\UserType;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('type')->default(UserType::RECEPTION);
            $table->tinyInteger('permission_to_delay')->default(HavePermission::TRUE);
            $table->tinyInteger('permission_to_delete')->default(HavePermission::TRUE);
            $table->tinyInteger('permission_to_update')->default(HavePermission::TRUE);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};