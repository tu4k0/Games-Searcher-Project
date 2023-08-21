<?php

namespace Database\Seeders;

use App\Constants\CategoryConstant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (CategoryConstant::CATEGORY_NAMES as $categoryId=>$categoryName) {
            DB::table('categories')->updateOrInsert(["id"=>$categoryId], ["name"=>$categoryName]);
        }
    }
}
