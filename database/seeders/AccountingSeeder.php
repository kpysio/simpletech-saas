<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Agency;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Task;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AccountingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    //  $user_kpys = User::create([
    //             'name' => "KPYS",
    //             'email' => 'kpys@agency.com',
    //             'password' => Hash::make('password'),
    //             'agency_id' => null,
    //         ]);

           // Create Agency
        $agency = Agency::create([
            'name' => 'MultiPackage Agency',
            'tenant_type' => 'accounting', // main type
            'created_by' => 1, // will update after admin user is created
        ]);

        

        // Create Admin User for Agency
        $adminUser = User::factory()->create([
            'name' => 'acc_admin_1',
            'email' => 'acc_admin_1@agency.com',
            'password' => Hash::make('password'),
            'agency_id' => $agency->id,
        ]);
        $adminRole = Role::where('name', 'agency_admin')->first();
        $adminUser->roles()->attach($adminRole);
        $agency->created_by = $adminUser->id;
        $agency->save();

        // Recruitment Package
        $recruitmentBranch = $agency->branches()->create(['name' => 'Finance Branch']);
        $managerRole = Role::where('name', 'agency_manager')->first();
        $recEmployees = [];
        foreach (['acc_emp_1', 'acc_emp_2', 'acc_emp_3'] as $empName) {
            $user = User::factory()->create([
                'name' => $empName,
                'email' => $empName.'@agency.com',
                'password' => Hash::make('password'),
                'agency_id' => $agency->id,
            ]);
            $user->roles()->attach($managerRole);
            $employee = Employee::factory()->create([
                'user_id' => $user->id,
                'branch_id' => $recruitmentBranch->id,
                'department' => 'accounting',
            ]);
            $recEmployees[] = $employee;
        }
        // Recruitment Clients
        $clientNum = 1;
        //$categories = ['Java', 'PHP', 'Nurse', 'Cleaner'];
        $categories = ['Corporation Tax', 'SA001', 'VAT', 'SE001'];

        foreach ($recEmployees as $employee) {
            for ($i = 0; $i < 3; $i++) {
                $user = User::factory()->create([
                    'name' => 'acc_client_' . $clientNum,
                    'email' => 'acc_client_' . $clientNum . '@client.com',
                    'password' => Hash::make('password'),
                    'agency_id' => $agency->id,
                ]);
                $client = Client::factory()->create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => null,
                    'employee_id' => $employee->id,
                    'department' => 'accounting',
                ]);

                
                foreach (range(1, 2) as $k) {
                    $client->tasks()->create([
                        'title' => ['VAT Return', 'SE001 Return', 'SA001 Return'][rand(0, 2)],
                        'category' => $categories[rand(0, 3)],
                        'due_date' => now()->addDays(rand(5, 15)),
                        'status' => 'open'
                    ]);
                }


                $clientNum++;
            }
        }

        // Create or fetch the tenant (e.g., accounting)
        $tenant = \App\Models\Tenant::firstOrCreate(['type' => 'accounting']);

        // Attach tenant to agency (many-to-many)
        $agency->tenants()->syncWithoutDetaching([$tenant->id]);

        // Create a task template for an agency and tenant
        $taskTemplate = \App\Models\TaskTemplate::create([
            'agency_id' => $agency->id,
            'tenant_id' => $tenant->id,
            'title' => 'VAT Return',
            'category' => 'Accounting',
            'description' => 'Prepare and file VAT return for the client.',
        ]);

        /**
         * Example:
         * \App\Models\TaskTemplate::create([
         *     'agency_id' => $agency->id,
         *     'tenant_id' => $tenant->id,
         *     'title' => 'Corporation Tax Return',
         *     'category' => 'Accounting',
         *     'description' => 'Prepare and file Corporation Tax return for the client.',
         * ]);
        */
        \App\Models\TaskTemplate::create([
            'agency_id' => $agency->id,
            'tenant_id' => $tenant->id,
            'title' => 'SA001 Return',
            'category' => 'Accounting',
            'description' => 'Prepare and file SA001 return for the client.',
        ]);
        \App\Models\TaskTemplate::create([
            'agency_id' => $agency->id,
            'tenant_id' => $tenant->id,
            'title' => 'Corporation Tax Return',
            'category' => 'Accounting',
            'description' => 'Prepare and file Corporation Tax return for the client.',
        ]);
                    
    }
}
