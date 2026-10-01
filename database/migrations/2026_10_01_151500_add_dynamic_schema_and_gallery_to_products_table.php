<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->string('sku')->nullable()->after('slug');
            $table->json('custom_fields')->nullable()->after('description');
            $table->json('images')->nullable()->after('custom_fields');
            $table->string('cover_image')->nullable()->after('images');
            $table->json('variants')->nullable()->after('cover_image');
            $table->json('validation_rules')->nullable()->after('variants');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'sku',
                'custom_fields',
                'images',
                'cover_image',
                'variants',
                'validation_rules',
            ]);
        });
    }
};
