<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;
use App\Role;
use App\Permission;
use App\Models\PermissionRole;
use App\Models\PermissionUser;
use App\Models\RoleUser;

class BasicAuthenticationsSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->command->info('disabling foreignkeys check');
        Schema::disableForeignKeyConstraints();
        $this->command->info('truncating permission_role...');
        DB::table('permission_role')->truncate();
        $this->command->info('truncating permission_user...');
        DB::table('permission_user')->truncate();
        $this->command->info('truncating user...');
        DB::table('users')->truncate();
        $this->command->info('truncating roles...');
        DB::table('roles')->truncate();
        $this->command->info('truncating permissions...');
        DB::table('permissions')->truncate();
        $this->command->info('truncating role_user...');
        DB::table('role_user')->truncate();
        $this->command->info('enabling foreignkeys check');
        Schema::enableForeignKeyConstraints();
        $builtInPermissions = [
            ['name' => 'kelolapengguna'],
            ['name' => 'kelolapengguna-pengguna'],
            ['name' => 'kelolapengguna-peran'],
            ['name' => 'kelolapengguna-hakakses']
        ];
        $builtInRolesAndUsers = [
            'super-admin' => [
                'name' => 'super-admin',
                'built_in' => 1,
                'permissions' => [
                    'kelolapengguna',
                    'kelolapengguna-pengguna',
                    'kelolapengguna-peran',
                    'kelolapengguna-hakakses',
                ],
                'user' => [
                    [
                        'name' => 'Super Admin',
                        'email' => 'super.admin@artcak.com',
                        'phone' => '001',
                        'password' => 'bismillah',
                        'is_active' => 1,
                        'built_in' => 1,
                    ],
                ],
            ],
            'personal' => [
                'name' => 'personal',
                'built_in' => 0,
                'permissions' => [
                ],
                'user' => [
                    [
                        'name' => 'User Dev',
                        'email' => 'dev@artcak.com',
                        'phone' => '08123456',
                        'password' => 'bismillah',
                        'is_active' => 1,
                        'built_in' => 0,
                    ],
                ],
            ],
        ];

        foreach ($builtInPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'display_name' => ucwords(str_replace('-', ' ', $permission['name'])),
                'description' => ucwords(str_replace('-', ' ', $permission['name'])),
                'built_in' => 1,
            ]);
            $this->command->info('Creating Permission: '. ucwords(str_replace('-', ' ', $permission['name'])));
        }
        foreach ($builtInRolesAndUsers as $key => $role) {
            $persistedRole = Role::create([
                'name' => $role['name'],
                'display_name' => ucwords(str_replace('-', ' ', $role['name'])),
                'description' => ucwords(str_replace('-', ' ', $role['name'])),
                'built_in' => $role['built_in'],
            ]);
            $this->command->info('Creating Role: '. ucwords(str_replace('-', ' ', $key)).' with '.@count($role['permissions']).' permissions.');

            $permissions = [];
            foreach ($role['permissions'] as $permissionName) {
                $permissions[] = Permission::where('name', $permissionName)->first();   
            }
            $persistedRole->attachPermissions($permissions);

            foreach ($role['user'] as $user) {
                $persistedUser = factory(User::class)->create($user);
                $this->command->info('Creating User: '. $user['name'].' ('.$user['email'].')');
                $persistedUser->attachRole($persistedRole);
                $this->command->info('Attach Role '. $persistedRole['display_name'] .' to User '. $user['name']);
            }
        }
    }
}
