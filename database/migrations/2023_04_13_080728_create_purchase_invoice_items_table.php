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
        Schema::create('purchase_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->integer('pi_id')->default(0);
            $table->integer('item_category')->default(0);
            $table->integer('item_unit')->default(0);
            $table->integer('item_id')->default(0);
            $table->decimal('qty',15,3)->default(0);
            $table->decimal('unit_price',15,3)->default(0);
            $table->decimal('amount',15,3)->default(0);
            $table->integer('currency_id')->default(0);
            $table->date('added_date');
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
        Schema::dropIfExists('purchase_invoice_items');
    }
};
