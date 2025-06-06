<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Agency;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Agency
        $agency = Agency::create([
            'name' => 'MultiPackage Agency',
            'industry_type' => 'recruitment', // main type
            'created_by' => 1, // will update after admin user is created
        ]);

        // Create Admin User for Agency
        $adminUser = User::create([
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
            $user = User::create([
                'name' => $empName,
                'email' => $empName.'@agency.com',
                'password' => Hash::make('password'),
                'agency_id' => $agency->id,
            ]);
            $user->roles()->attach($managerRole);
            $employee = Employee::create([
                'user_id' => $user->id,
                'branch_id' => $recruitmentBranch->id,
                'department' => 'Recruitment',
            ]);
            $recEmployees[] = $employee;
        }
        // Recruitment Clients
        $clientNum = 1;
        foreach ($recEmployees as $employee) {
            for ($i = 0; $i < 3; $i++) {
                $user = User::create([
                    'name' => 'rec_client_' . $clientNum,
                    'email' => 'rec_client_' . $clientNum . '@client.com',
                    'password' => Hash::make('password'),
                    'agency_id' => $agency->id,
                ]);
                Client::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => null,
                    'employee_id' => $employee->id,
                    'department' => 'recruitment',
                ]);
                $clientNum++;
            }
        }

        // Accounting Package
        $accountingBranch = $agency->branches()->create(['name' => 'Accounting Branch']);
        $accEmployees = [];
        foreach (['acc_emp_1', 'acc_emp_2', 'acc_emp_3'] as $empName) {
            $user = User::create([
                'name' => $empName,
                'email' => $empName.'@agency.com',
                'password' => Hash::make('password'),
                'agency_id' => $agency->id,
            ]);
            $user->roles()->attach($managerRole);
            $employee = Employee::create([
                'user_id' => $user->id,
                'branch_id' => $accountingBranch->id,
                'department' => 'Accounting',
            ]);
            $accEmployees[] = $employee;
        }
        // Accounting Clients
        $clientNum = 1;
        foreach ($accEmployees as $employee) {
            for ($i = 0; $i < 3; $i++) {
                $user = User::create([
                    'name' => 'acc_client_' . $clientNum,
                    'email' => 'acc_client_' . $clientNum . '@client.com',
                    'password' => Hash::make('password'),
                    'agency_id' => $agency->id,
                ]);
                Client::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => null,
                    'employee_id' => $employee->id,
                    'department' => 'accounting',
                ]);
                $clientNum++;
            }
        }
    }
}
