<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => config('constant.add-project'),'guard_name' => 'web',
            'group'=>config('constant.project-group')],
            ['name' => config('constant.edit-project'),'guard_name' => 'web',
            'group'=>config('constant.project-group'),],
            ['name' => config('constant.delete-project'),'guard_name' => 'web',
            'group'=>config('constant.project-group')],
            ['name' => config('constant.list-project'),'guard_name' => 'web',
            'group'=>config('constant.project-group')],


            ['name' => config('constant.add-task'),'guard_name' => 'web',
            'group'=>config('constant.task-group')],
            ['name' => config('constant.edit-task'),'guard_name' => 'web',
            'group'=>config('constant.task-group'),],
            ['name' => config('constant.delete-task'),'guard_name' => 'web',
            'group'=>config('constant.task-group')],
            ['name' => config('constant.list-task'),'guard_name' => 'web',
            'group'=>config('constant.task-group')],

            ['name' => config('constant.list-comment'),'guard_name' => 'web',
            'group'=>config('constant.comment-group')],
            ['name' => config('constant.view-comment'),'guard_name' => 'web',
            'group'=>config('constant.comment-group')],

            ['name' => config('constant.add-user'),'guard_name' => 'web',
            'group'=>config('constant.user-group')],
            ['name' => config('constant.edit-user'),'guard_name' => 'web',
            'group'=>config('constant.user-group'),],
            ['name' => config('constant.delete-user'),'guard_name' => 'web',
            'group'=>config('constant.user-group')],
            ['name' => config('constant.list-user'),'guard_name' => 'web',
            'group'=>config('constant.user-group')],

            ['name' => config('constant.list-role'),'guard_name' => 'web',
            'group'=>config('constant.role-group')],
            ['name' => config('constant.assign-permission'),'guard_name' => 'web',
            'group'=>config('constant.role-group')],
        ];
        Permission::insert($permissions);
    }
}
