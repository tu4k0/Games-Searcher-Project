<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Constants\RoleConstant;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RoleConstant::ROLES as $roleId=> $roleName) {
            DB::table('roles')->updateOrInsert(["id" => $roleId], ["id" => $roleId, "name" => $roleName]);
        }
    }
}
