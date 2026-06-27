<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Keep existing data working: nullable additions.
            $table->string('slug')->nullable()->unique()->after('name');

            $table->foreignId('brand_id')->nullable()->after('slug')->constrained('brands')->nullOnDelete();

            $table->string('skin_type')->nullable()->after('brand_id');
            $table->string('volume')->nullable()->after('skin_type');
            $table->text('ingredients')->nullable()->after('volume');

            // status: active/inactive/archived etc.
            $table->string('status')->default('active')->after('ingredients');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('brand_id');
            $table->dropColumn('brand_id');
            $table->dropColumn('slug');
            $table->dropColumn('skin_type');
            $table->dropColumn('volume');
            $table->dropColumn('ingredients');
            $table->dropColumn('status');
        });
    }
};

