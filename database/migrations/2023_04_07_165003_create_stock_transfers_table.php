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
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->date('st_date');
            $table->string('ref_no',120);
            $table->integer('item_id')->default(0);
            $table->integer('from_warehouse_id')->default(0);
            $table->integer('to_warehouse_id')->default(0);
            $table->decimal('qty',15,3);
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('stock_transfers');
    }
};
