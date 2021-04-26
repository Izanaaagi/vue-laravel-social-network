<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionBootstrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createRolesPermissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create roles and permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $roles = ['Admin', 'User'];
        $permissions = ['Change username', 'Change password', 'Delete topic', 'Create admin topics'];

        $this->line('---- Setting up roles:');

        foreach ($roles as $role) {
            $role = Role::updateOrCreate(['name' => $role, 'guard_name' => 'api']);
            $this->info("Created " . $role->name . " Role");
        }

        $this->line('------------- Setting Up Permissions:');

        $superAdmin = Role::where('name', 'Admin')->first();

        foreach ($permissions as $perm_name) {
            $permission = Permission::updateOrCreate(['name' => $perm_name,
                'guard_name' => 'api']);

            $superAdmin->givePermissionTo($permission);

            $this->info("Created " . $permission->name . " Permission");
        }

        $this->info("All permissions are granted to Super Admin");
        $this->line('------------- Application Bootstrapping is Complete: \n');


        User::find(1)->assignRole('Admin');
    }
}