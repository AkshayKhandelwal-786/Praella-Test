<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Helpers;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDate = Helpers::crrrentDateTime();
        $role = Role::ROLE_NAME;
        $roleType = Role::ROLE_TYPE;

        $roles = [
            [
                'name'       => $role['Admin'],
                'guard_name' => 'web',
                'is_primary' => $roleType['Primary'],
                'created_at' => $currentDate,
                'updated_at' => $currentDate
            ],
            [
                'name'       => $role['Super-Admin'],
                'guard_name' => 'web',
                'is_primary' => $roleType['Not Primary'],
                'created_at' => $currentDate,
                'updated_at' => $currentDate
            ],
            [
                'name'       => $role['User'],
                'guard_name' => 'web',
                'created_at' => $currentDate,
                'is_primary' => $roleType['Not Primary'],
                'updated_at' => $currentDate
            ],
        ];
        Role::insert($roles);
    }
}
