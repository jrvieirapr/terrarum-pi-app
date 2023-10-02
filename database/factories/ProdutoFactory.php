<?php

namespace Database\Factories;

use App\Models\Destino;
use App\Models\TipoProduto;
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
            //
            'descricao' => $this->faker->unique()->word,
            'esta_ativo' => $this->faker->boolean,
            'tipo_produto_id' => function () {
                return TipoProduto::factory()->create()->id;
            },
            'destino_id' => function () {
                return Destino::factory()->create()->id;
            },
        ];
    }
}
