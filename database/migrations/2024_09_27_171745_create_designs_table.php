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
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('thumbnail');
            $table->integer('marla');
            $table->integer('no_of_rooms');
            $table->integer('no_of_floors');
            $table->text('description')->nullable();
            $table->string('type'); // 2D, 3D 
            $table->decimal('price', 10, 2)->nullable();
            $table->foreignId('category_id')->constrained('categories', 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
