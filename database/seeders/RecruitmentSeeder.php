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

class RecruitmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user_kpys = User::create([
                'name' => "KPYS",
                'email' => 'kpys@agency.com',
                'password' => Hash::make('password'),
                'agency_id' => null,
            ]);

           // Create Agency
        $agency = Agency::create([
            'name' => 'MultiPackage Agency',
            'tenant_type' => 'recruitment', // main type
            'created_by' => $user_kpys->id, // will update after admin user is created
        ]);

        // Create Admin User for Agency
        $adminUser = User::factory()->create([
            'name' => 'rec_admin_1',
            'email' => 'rec_admin_1@agency.com',
            'password' => Hash::make('password'),
            'agency_id' => $agency->id,
        ]);
        $adminRole = Role::where('name', 'agency_admin')->first();
        $adminUser->roles()->attach($adminRole);
        $agency->created_by = $adminUser->id;
        $agency->save();

        // Recruitment Package
        $recruitmentBranch = $agency->branches()->create(['name' => 'Recruitment Branch']);
        $managerRole = Role::where('name', 'agency_manager')->first();
        $recEmployees = [];
        foreach (['rec_emp_1', 'rec_emp_2', 'rec_emp_3'] as $empName) {
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
                'department' => 'Recruitment',
            ]);
            $recEmployees[] = $employee;
        }
        // Recruitment Clients
        $clientNum = 1;
        $categories = ['Java', 'PHP', 'Nurse', 'Cleaner'];

        foreach ($recEmployees as $employee) {
            for ($i = 0; $i < 3; $i++) {
                $user = User::factory()->create([
                    'name' => 'rec_client_' . $clientNum,
                    'email' => 'rec_client_' . $clientNum . '@client.com',
                    'password' => Hash::make('password'),
                    'agency_id' => $agency->id,
                ]);
                $client = Client::factory()->create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => null,
                    'employee_id' => $employee->id,
                    'department' => 'recruitment',
                ]);

                
                foreach (range(1, 2) as $k) {
                    $client->tasks()->create([
                        'title' => ['Java Developer', 'PHP Dev', 'Nurse'][rand(0, 2)],
                        'category' => $categories[rand(0, 3)],
                        'due_date' => now()->addDays(rand(5, 15)),
                        'status' => 'open'
                    ]);
                }


                $clientNum++;
            }
        }

             // Create or fetch the tenant (e.g., accounting)
        $tenant = \App\Models\Tenant::firstOrCreate(['type' => 'recruitment']);

        // Attach tenant to agency (many-to-many)
        $agency->tenants()->syncWithoutDetaching([$tenant->id]);

        // Create a task template for an agency and tenant
        $taskTemplate = \App\Models\TaskTemplate::create([
            'agency_id' => $agency->id,
            'tenant_id' => $tenant->id,
            'title' => 'Job Application',
            'category' => 'Recruitment',
            'description' => 'Prepare Job Application for the client.',
        ]);

    }
}
