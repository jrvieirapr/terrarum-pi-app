<?php

namespace Database\Factories;

use App\Models\DetalhePedido;
use App\Models\Pedido;
use App\Models\Usuario;
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

            'data' => $this->faker->date,
            'numero' => $this->faker->unique()->randomNumber(5),
            'esta_ativo' => $this->faker->boolean,
            'usuario_id' => function () {
                return Usuario::factory()->create()->id;
            },
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Pedido $pedido) {
            // Adicione 5 detalhes de pedido associados ao pedido
            DetalhePedido::factory(5)->create(['pedido_id' => $pedido->id]);
        });
    }
}
