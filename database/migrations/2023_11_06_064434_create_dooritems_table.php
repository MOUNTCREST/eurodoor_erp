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
        Schema::create('dooritems', function (Blueprint $table) {
            $table->id();
            $table->string('model_name',120);
            $table->string('ref_no',120);
            $table->string('color_type',120);
            $table->integer('color_id')->default(0);
            $table->decimal('resin_qty',15,3)->default(0);
            $table->decimal('paint_qty_color_1',15,3)->default(0);
            $table->decimal('paint_qty_color_2',15,3)->default(0);
            $table->decimal('paint_qty_color_3',15,3)->default(0);
            $table->integer('company_id')->default(0);
            $table->integer('delete_status')->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('edited_by')->default(0);
            $table->integer('deleted_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dooritems');
    }
};
