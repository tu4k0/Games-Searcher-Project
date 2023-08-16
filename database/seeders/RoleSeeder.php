<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Constants\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Role::$roles as $roleId=>$roleName) {
            DB::table('roles')->updateOrInsert(["id" => $roleId], ["id" => $roleId, "name" => $roleName]);
        }
    }
}
