<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' =>''.$this->faker->numberBetween($int1 = 0 , $int2 = 999),
            'descricao' => $this->faker->sentence(),
            'destino_id' => $this->faker->numberBetween($int1 = 0, $int2 = 999),
            'tipos_de_produtos_id' => fake()->numberBetween($int1 = 0, $int2 = 999),
            'esta_ativo' => $this->faker->numberBetween($int1 = 1, $int2 = 2),
        ];
    }
}
