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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->date('t_date');
            $table->string('t_no',120);
            $table->string('type',120);
            $table->integer('currency_id')->default(0);
            $table->decimal('amount',15,3);
            $table->text('narration')->nullable();
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('accounts');
    }
};
