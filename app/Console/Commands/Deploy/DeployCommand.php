<?php

namespace App\Console\Commands\Deploy;

use App\Models\Employee;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class DeployCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'launch:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This script is launched every time it is deployed.';

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
        Artisan::call('migrate');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('clear-compiled');

        $this->createUpdatePermissions();


        $this->optimizeApp();
        $this->info('Scripts launched successfully');
    }

    private function optimizeApp() {
        try {
            if (config('app.env') == 'production') {
                // composer install --optimize-autoloader --no-dev
                Artisan::call('optimize');
                Artisan::call('config:cache');
                Artisan::call('route:cache');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        $this->info('Ready app optimization');
    }

    private function createUpdatePermissions() {

        try {

            $roles = config('albia.roles');
            $arrayRoles = [];

            foreach ($roles as $r) {
                Role::updateOrCreate(
                    ['id' => $r['id']],
                    ['name' => $r['name']]
                );
                $arrayRoles[] = $r['name'];
            }
            $deleteRoles = Role::whereNotIn('name', $arrayRoles)->pluck('id');
            Role::destroy($deleteRoles);

            $permissions = config('albia.permissions');
            $arrayPermissions = [];

            foreach ($permissions as $p) {
                $permission = Permission::updateOrCreate(['name' => $p['name']]);
                $arrayPermissions[] = $p['name'];
                $permission->syncRoles(Role::whereIn('id', $p['roles'])->get());
            }
            $deletePermissions = Permission::whereNotIn('name', $arrayPermissions)->pluck('id');
            Permission::destroy($deletePermissions);

            $employees_admin = config('albia.employees_admin');
            foreach ($employees_admin as $e) {
                $employee = Employee::updateOrCreate(
                    ['email' => $e['email']],
                    ['name' => $e['name'], 'password' => Hash::make($e['password'])]
                );
                $employee->assignRole(Role::find($e['role']));
            }

        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        $this->info('Updated roles and permissions');
    }
}
