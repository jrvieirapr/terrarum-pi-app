<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'id' => '' . $this->faker->numberBetween($int1 = 0, $int2 = 99999),

            'data' => $this->faker->date,

            'produto' => $this->faker->name(),

            'quantidade' => '' . $this->faker->numberBetween($int1 = 0, $int2 = 999),

            'preco' => '' . $this->faker->numberBetween($int1 = 1, $int2 = 99),

            'total' => '' . $this->faker->numberBetween($int1 = 1, $int2 = 999),

            'obs' => '' . $this->faker->sentence(),

            'usuarios_id' => '' . $this->faker->numberBetween($int1 = 1, $int2 = 99999),

            'detalhes_pedido_id' => '' . $this->faker->numberBetween($int1 = 1, $int2 = 99999),
        ];
    }
}
