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
        Schema::create('black_or_whites', function (Blueprint $table) {
            $table->id();
            $table->integer('ledger_id')->default(0);
            $table->decimal('white_amount',15,3)->default(0);
            $table->decimal('black_amount',15,3)->default(0);
            $table->string('type',120);
            $table->integer('company_id')->default(0);
            $table->integer('delete_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('black_or_whites');
    }
};
