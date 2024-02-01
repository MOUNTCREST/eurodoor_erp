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
        Schema::create('multi_currency_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no',120);
            $table->date('date');
            $table->integer('account_id')->default(0);
            $table->integer('account_cr')->default(0);
            $table->integer('account_dr')->default(0);
            $table->decimal('current_rate',15,3)->default(0);
            $table->integer('from_currency')->default(0);
            $table->decimal('from_amount',15,3)->default(0);
            $table->integer('to_currency')->default(0);
            $table->decimal('to_amount',15,3)->default(0);
            $table->text('narration')->nullable();
            $table->string('m_d_type',120)->nullable();
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
        Schema::dropIfExists('multi_currency_transfers');
    }
};
