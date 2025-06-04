<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Java', 'PHP', 'Nurse', 'Cleaner'];
        $titles = ['Java Developer', 'PHP Dev', 'Nurse'];
        $statuses = ['open', 'in_progress', 'completed', 'cancelled'];
        return [
            'client_id' => null, // Set in seeder
            'title' => $this->faker->randomElement($titles),
            'category' => $this->faker->randomElement($categories),
            'due_date' => $this->faker->dateTimeBetween('+5 days', '+15 days'),
            'status' => $this->faker->randomElement($statuses),
        ];
    }
}
