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

class RealEstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a user to be the agency creator
        $user = User::factory()->create([
            'name' => 'Real Estate Owner',
            'email' => 'owner@realestate.com',
        ]);

        $adminRole = Role::where('name', 'Admin')->first();
        $user->roles()->attach($adminRole);

        $agency = Agency::create([
            'name' => 'Real Estate Group',
            'industry_type' => 'real_estate',
            'created_by' => $user->id,
        ]);

        $branch = $agency->branches()->create([
            'name' => 'Property Branch',
        ]);

        $employees = Employee::factory(4)->create([
            'branch_id' => $branch->id,
        ]);

        $categories = ['Residential', 'Commercial', 'Sales', 'Letting'];

        $agentRole = Role::where('name', 'Agent')->first();
        foreach ($employees->take(3) as $agent) {
            $agentUser = $agent->user;
            if ($agentUser) {
                $agentUser->roles()->attach($agentRole);
            }
            for ($j = 0; $j < 3; $j++) {
                $client = $agent->clients()->create([
                    'name' => "Owner {$j}",
                    'department' => 'Real Estate',
                ]);

                foreach (range(1, 2) as $k) {
                    $client->tasks()->create([
                        'title' => ['Property Selling', 'Viewing Booking', 'Maintenance'][rand(0, 2)],
                        'category' => $categories[rand(0, 3)],
                        'due_date' => now()->addDays(rand(7, 20)),
                        'status' => 'open'
                    ]);
                }
            }
        }
    }
}
