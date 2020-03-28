<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'inventory.list',
            'inventory.create',
            'inventory.edit',
            'inventory.delete',
            'sales.list',
            'sales.create',
            'sales.edit',
            'sales.delete',
            'pos.list',
            'pos.create',
            'pos.edit',
            'pos.delete',
            'hr.list',
            'hr.create',
            'hr.edit',
            'hr.delete',
            'admin.list',
            'admin.create',
            'admin.edit',
            'admin.delete',
            'user.list',
            'user.create',
            'user.edit',
            'user.delete'
         ];
 
 
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
         
        // create roles and assign created permissions
        $role = Role::create(['name' => 'user'])
            ->givePermissionTo(['pos.list', 'pos.create', 'pos.edit', 'pos.delete',
                                'sales.list', 'sales.create', 'sales.edit', 'sales.delete',
                                'inventory.list', 'inventory.create', 'inventory.edit', 'inventory.delete',]);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $user = User::find(1);
        $user->assignRole('admin');

        $user2 = User::find(2);
        $user2->assignRole('user');

    }
}
