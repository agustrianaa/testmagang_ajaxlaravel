<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class programFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'sumber_dana'=>$this->faker->sumber_dana(),
            // 'program'=>$this->faker->program(),
            // 'keterangan'=>$this->faker->keterangan(),
        ];
    }
}
