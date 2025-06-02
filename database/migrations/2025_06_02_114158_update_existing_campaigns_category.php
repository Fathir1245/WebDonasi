<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get the first category (or create a default one)
        $defaultCategory = DB::table('categories')->first();
        
        if (!$defaultCategory) {
            // If no categories exist, create a default one
            $defaultCategoryId = DB::table('categories')->insertGetId([
                'name' => 'Lainnya',
                'slug' => 'lainnya',
                'description' => 'Kategori umum untuk campaign',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $defaultCategoryId = $defaultCategory->id;
        }
        
        // Update all campaigns that don't have a category
        DB::table('campaigns')
            ->whereNull('category_id')
            ->update(['category_id' => $defaultCategoryId]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set category_id back to null for campaigns that were updated
        DB::table('campaigns')
            ->where('category_id', function($query) {
                $query->select('id')
                      ->from('categories')
                      ->where('slug', 'lainnya')
                      ->limit(1);
            })
            ->update(['category_id' => null]);
    }
};
