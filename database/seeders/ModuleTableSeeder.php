<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleModule;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder
{
    public function run()
    {
        Role::truncate();
        Module::truncate();
        RolePermission::truncate();
        RoleModule::truncate();
        Permission::truncate();

        $modules = [
            [
                'name' => 'Job',
                'key' => 'job',
                'link' => '#',
                'icon' => 'fa-briefcase',
                'permission' => ['add', 'view', 'edit','update', 'delete'],
                'submenus' => [
                    ['name' => 'Job Category',
                        'key' => 'category',
                        'link' => '/admin/jobcategory/category',
                        'icon' => 'fa-folder',
                        'permission' => ['add', 'view', 'edit', 'update','delete'],
                    ],
                    ['name' => 'Company',
                        'key' => 'company',
                        'link' => '/admin/jobcategory/company',
                        'icon' => 'fa-building',
                        'permission' => ['add', 'view', 'edit', 'update','delete'],
                    ],
                    ['name' => 'Job Post',
                        'key' => 'joblist',
                        'link' => '/admin/jobcategory/joblist',
                        'icon' => 'fa-file-alt',
                        'permission' => ['add', 'view', 'edit','update', 'delete'],
                    ]
                ],
            ],
            [
                'name' => 'Blog',
                'key' => 'blog',
                'link' => '#',
                'icon' => 'fa-blog',
                'permission' => ['add', 'view', 'edit', 'update','delete'],
                'submenus' => [
                    ['name' => 'Blog Post',
                        'key' => 'blogpost',
                        'link' => '/admin/blog/blogpost',
                        'icon' => 'fa-pen',
                        'permission' => ['add', 'view', 'edit','update', 'delete'],
                    ],
                ],
            ],
            [
                'name' => 'Application',
                'key' => 'apply',
                'link' => '#',
                'icon' => 'fa-file-alt',
                'permission' => ['add', 'view', 'edit','update', 'delete'],
                'submenus' => [
                    [
                        'name' => 'Application',
                        'key' => 'application',
                        'link' => '/admin/seeker/application',
                        'icon' => 'fa-pen',
                        'permission' => ['add', 'view', 'edit','update', 'delete'],
                    ],
                ],
            ],
            [
                'name' => 'RolePermission',
                'key' => 'rolepermission',
                'link' => '#',
                'icon' => 'fa-file-alt',
                'permission' => ['add', 'view', 'edit', 'update','delete'],
                'submenus' => [
                    [
                        'name' => 'Role User Management',
                        'key' => 'roleusermanagement',
                        'link' => '/admin/role/rolepermissions',
                        'icon' => 'fa-users',
                        'permission' => ['add', 'view', 'edit','update', 'delete'],
                    ],
                    [
                        'name' => 'Role',
                        'key' => 'role',
                        'link' => '/admin/role/role',
                        'icon' => 'fa-user-shield',
                        'permission' => ['add', 'view', 'edit', 'update','delete'],
                    ],
                    [
                        'name' => 'Role Permission',
                        'key' => 'rolepermission',
                        'link' => '/admin/role/permissions',
                        'icon' => 'fa-lock',
                        'permission' => ['add', 'view', 'edit','update', 'delete'],
                    ],
                ],
            ]


        ];

        $adminRole = Role::create(['name' => 'Admin']);

        User::where('id', 1)->update(['role_id' => $adminRole->id]);

        foreach ($modules as $eachModule) {
            $this->RoleWithPermissions($eachModule, $adminRole);
        }
    }

    private function RoleWithPermissions(array $moduleData, Role $role, $parentId = 0)
    {
        $module = Module::create([
            'name' => $moduleData['name'],
            'link' => $moduleData['link'],
            'parent_id' => $parentId,
            'icon' => $moduleData['icon'],
        ]);

        RoleModule::create([
            'role_id' => $role->id,
            'module_id' => $module->id,
        ]);

        foreach ($moduleData['permission'] as $permission) {
            $permissionModel = Permission::create([
                'module_id' => $module->id,
                'name' => $moduleData['key'] . "_" . $permission,
            ]);

            RolePermission::create([
                'role_id' => $role->id,
                'permission_id' => $permissionModel->id,
            ]);
        }

        if (isset($moduleData['submenus']) && is_array($moduleData['submenus'])) {
            foreach ($moduleData['submenus'] as $subModuleData) {
                $this->RoleWithPermissions($subModuleData, $role, $module->id);
            }
        }
    }
}