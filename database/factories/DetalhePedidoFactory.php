<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetalhePedido>
 */
class DetalhePedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => $this->faker->sentence,
            'pedido_id' => function () {
                return Pedido::factory()->create()->id;
            },
            'evento_id' => function () {
                return Evento::factory()->create()->id;
            },
            'produto_id' => function () {
                return Produto::factory()->create()->id;
            },
            'quantidade' => $this->faker->numberBetween(1, 10),
            'valor_unitario' => $this->faker->randomFloat(2, 10, 100),
            'valor_total' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}