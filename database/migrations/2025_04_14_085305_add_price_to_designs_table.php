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
        // Check if the price column doesn't exist before adding it
        if (!Schema::hasColumn('designs', 'price')) {
            Schema::table('designs', function (Blueprint $table) {
                $table->decimal('price', 10, 2)->after('type')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only drop if the column exists
        if (Schema::hasColumn('designs', 'price')) {
            Schema::table('designs', function (Blueprint $table) {
                $table->dropColumn('price');
            });
        }
    }
};
