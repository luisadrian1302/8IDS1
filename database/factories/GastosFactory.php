<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gastos>
 */
class GastosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->word,
            "descripcion" => $this->faker->word,
            "monto" => $this->faker->numerify,
            "fecha_gasto" => $this->faker->date,
            "id_categoria" => $this->faker->numerify,
            "id_users" => $this->faker->numerify,
            
        ];
    }
}
