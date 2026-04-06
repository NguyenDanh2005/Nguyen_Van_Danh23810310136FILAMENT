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
    Schema::create('sv23810310136_products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('sv23810310136_categories')->onDelete('cascade');
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->decimal('price', 12, 0);      // không âm – validation ở form
        $table->integer('stock_quantity');    // số nguyên
        $table->string('image_path')->nullable();
        $table->enum('status', ['draft', 'published', 'out_of_stock'])->default('draft');
        $table->string('brand_origin')->nullable(); // 🎯 TRƯỜNG SÁNG TẠO
        $table->timestamps();
    });
}
};
