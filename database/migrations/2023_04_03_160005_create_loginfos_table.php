<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loginfos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('role',120);
            $table->dateTime('login_date_time');
            $table->dateTime('logout_date_time');
            $table->string('ipaddress',120);
            $table->string('location',120);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loginfos');
    }
};
