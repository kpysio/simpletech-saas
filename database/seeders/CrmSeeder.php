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

        $adminRole = Role::where('name', 'agency_admin')->first();
        $user->roles()->attach($adminRole);

        $agency = Agency::create([
            'name' => 'CRM Solutions',
            'tenant_type' => 'crm',
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

                   // Create or fetch the tenant (e.g., accounting)
        $tenant = \App\Models\Tenant::firstOrCreate(['type' => 'crm']);

        // Attach tenant to agency (many-to-many)
        $agency->tenants()->syncWithoutDetaching([$tenant->id]);

        // Create a task template for an agency and tenant
        $taskTemplate = \App\Models\TaskTemplate::create([
            'agency_id' => $agency->id,
            'tenant_id' => $tenant->id,
            'title' => 'CRM Management',
            'category' => 'CRM',
            'description' => 'Prepare Lead management for the client.',
        ]);
    }
}
