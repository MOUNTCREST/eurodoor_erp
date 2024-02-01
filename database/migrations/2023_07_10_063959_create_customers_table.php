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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name',120);
            $table->string('mobile_no',120);
            $table->string('code',120);
            $table->string('email_id',120);
            $table->string('gst_no',120);
            $table->string('credit_limit',120);
            $table->decimal('discount',15,3)->default(0);
            $table->text('permenant_address')->nullable();
            $table->text('contact_address')->nullable();
            $table->text('web_address')->nullable();
            $table->integer('country')->default(0);
            $table->integer('currency')->default(0);
            $table->text('remarks')->nullable();
            $table->integer('location')->default(0);
            $table->integer('ledger_id')->default(0);
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
        Schema::dropIfExists('customers');
    }
};
