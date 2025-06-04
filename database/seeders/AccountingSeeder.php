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
            'industry_type' => 'accounting', // main type
            'created_by' => 1, // will update after admin user is created
        ]);

        // Create Admin User for Agency
        $adminUser = User::factory()->create([
            'name' => 'acc_admin_1',
            'email' => 'acc_admin_1@agency.com',
            'password' => Hash::make('password'),
            'agency_id' => $agency->id,
        ]);
        $adminRole = Role::where('name', 'Admin')->first();
        $adminUser->roles()->attach($adminRole);
        $agency->created_by = $adminUser->id;
        $agency->save();

        // Recruitment Package
        $recruitmentBranch = $agency->branches()->create(['name' => 'Finance Branch']);
        $managerRole = Role::where('name', 'Manager')->first();
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





/*
        // Create a user to be the agency creator
        $user = User::factory()->create([
            'name' => 'Accounting Owner',
            'email' => 'owner@accounting.com',
        ]);

        $adminRole = Role::where('name', 'Admin')->first();
        $user->roles()->attach($adminRole);

        $agency = Agency::create([
            'name' => 'Accounting Experts',
            'industry_type' => 'accounting',
            'created_by' => $user->id,
        ]);

        $branch = $agency->branches()->create([
            'name' => 'Finance Branch',
        ]);

        $employees = Employee::factory(4)->create([
            'branch_id' => $branch->id,
        ]);

        $categories = ['Corporation Tax', 'SA001', 'VAT'];

        $accountantRole = Role::where('name', 'Accountant')->first();
        foreach ($employees->take(3) as $accountant) {
            $accountantUser = $accountant->user;
            if ($accountantUser) {
                $accountantUser->roles()->attach($accountantRole);
            }
            for ($j = 0; $j < 3; $j++) {
                $client = $accountant->clients()->create([
                    'name' => "Client {$j}",
                    'department' => 'Finance',
                ]);

                foreach (range(1, 2) as $k) {
                    $client->tasks()->create([
                        'title' => ['VAT Return', 'SE001 Return', 'SA001 Return'][rand(0, 2)],
                        'category' => $categories[rand(0, 2)],
                        'due_date' => now()->addDays(rand(10, 30)),
                        'status' => 'open'
                    ]);
                }
            }
        }
        */
    }
}
