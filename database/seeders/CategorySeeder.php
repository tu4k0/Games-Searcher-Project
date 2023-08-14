<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    private array $categoryNames = [
        1 => 'main_game',
        2 => 'dlc_addon',
        3 => 'expansion',
        4 => 'bundle',
        5 => 'standalone_expansion',
        6 => 'mod',
        7 => 'episode',
        8 => 'season',
        9 => 'remake',
        10 => 'remaster',
        11 => 'expanded_game',
        12 => 'port',
        13 => 'fork',
        14 => 'pack',
        15 => 'update',
    ];

    public function run(): void
    {
        foreach ($this->categoryNames as $categoryId=>$categoryName) {
            DB::table('categories')->updateOrInsert(["id"=>$categoryId], ["name"=>$categoryName]);
        }
    }
}
