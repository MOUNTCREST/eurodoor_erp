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
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('s_i_no',120);
            $table->date('s_date');
            $table->integer('customer_id')->default(0);
            $table->integer('currency_id')->default(0);
            $table->integer('sales_account_id')->default(0);
            $table->decimal('sub_total',15,3)->default(0);
            $table->decimal('total',15,3)->default(0);
            $table->text('narration')->nullable();
            $table->integer('warehouse_id')->default(0);
            $table->integer('account_id')->default(0);
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
        Schema::dropIfExists('sales_invoices');
    }
};
