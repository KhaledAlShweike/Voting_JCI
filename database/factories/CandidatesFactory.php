<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Candidates;
use App\Models\Categories;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidates>
 */
class CandidatesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Candidates::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'position' => $this->faker->word, // Random word for position
            'last_position' => $this->faker->word, // Random word for last position
            'jci_career' => $this->faker->sentence, // Random sentence for career
            'category_id' => Categories::factory(), // Create a new category for this candidate
        ];
    }
}
