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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('ref_no',120)->nullable();
            $table->integer('item_id')->default(0);
            $table->integer('item_category_id')->default(0);
            $table->integer('item_unit_id')->default(0);
            $table->decimal('qty',15,3)->default(0);
            $table->string('type',120)->default(0);
            $table->integer('p_id')->default(0);
            $table->integer('s_id')->default(0);
            $table->integer('st_id')->default(0);
            $table->integer('warehouse_id')->default(0);
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
        Schema::dropIfExists('stocks');
    }
};
