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

class CrmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a user to be the agency creator
        $user = User::factory()->create([
            'name' => 'CRM Owner',
            'email' => 'owner@crm.com',
        ]);

        $adminRole = Role::where('name', 'Admin')->first();
        $user->roles()->attach($adminRole);

        $agency = Agency::create([
            'name' => 'CRM Solutions',
            'industry_type' => 'crm',
            'created_by' => $user->id,
        ]);

        $branch = $agency->branches()->create([
            'name' => 'Sales Branch',
        ]);

        $employees = Employee::factory(4)->create([
            'branch_id' => $branch->id,
        ]);

        $categories = ['Lead Nurturing', 'Deal Closing', 'Onboarding'];

        $salesRepRole = Role::where('name', 'SalesRep')->first();
        foreach ($employees->take(3) as $salesRep) {
            $salesRepUser = $salesRep->user;
            if ($salesRepUser) {
                $salesRepUser->roles()->attach($salesRepRole);
            }
            for ($j = 0; $j < 3; $j++) {
                $client = $salesRep->clients()->create([
                    'name' => "Lead {$j}",
                    'department' => 'Sales',
                ]);

                foreach (range(1, 2) as $k) {
                    $client->tasks()->create([
                        'title' => ['Demo Call', 'Follow-up Email', 'Client Meeting'][rand(0,2)],
                        'category' => $categories[rand(0,2)],
                        'due_date' => now()->addDays(rand(5, 30)),
                        'status' => 'open'
                    ]);
                }
            }
        }
    }
}
