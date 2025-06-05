<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RoleSeeder::class);
        $this->call(RecruitmentSeeder::class);
        $this->call(AccountingSeeder::class);
        $this->call(RealEstateSeeder::class);
        $this->call(CrmSeeder::class);
      //  $this->call(UserSeeder::class);
    }
}
