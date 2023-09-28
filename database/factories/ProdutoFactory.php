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
            'id' =>''.$this->faker->numberBetween($int1 = 0 , $int2 = 99999),
            'descricao' => $this->faker->sentence(),
            'destino_id' => $this->faker->numberBetween($int1 = 0, $int2 = 99999),
            'tipo_de_produto_id' => fake()->unique()->name(),
            'esta_ativo' => $this->faker->sentence(),
        ];
    }
}
