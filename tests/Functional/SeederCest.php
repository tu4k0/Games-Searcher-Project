<?php


namespace Tests\Functional;

use App\Constants\RoleConstant;
use App\Models\Category;
use App\Models\Role;
use Database\Seeders\CategorySeeder;
use Tests\Support\FunctionalTester;
use App\Constants\CategoryConstant;

class SeederCest
{
    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function categorySeederSuccess(FunctionalTester $I): void
    {
        $I->callArtisan('db:seed', ['class' => CategorySeeder::class]);
        foreach (CategoryConstant::CATEGORY_NAMES as $categoryName) {
            $I->seeRecord(Category::class, ['name' => $categoryName]);
        }
    }

    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function roleSeederSuccess(FunctionalTester $I): void
    {
        $I->callArtisan('db:seed', ['class' => CategorySeeder::class]);
        foreach (RoleConstant::ROLES as $roleName) {
            $I->seeRecord(Role::class, ['name' => $roleName]);
        }
    }
}
