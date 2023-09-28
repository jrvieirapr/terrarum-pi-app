<?php

namespace Database\Factories;

use App\Models\Destino;
use App\Models\TipoProduto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Nome' =>''.$this->faker->word.''.
                $this->faker->numberBetween($int1 = 0 , $int2 = 99999),
            'Descricao' => $this->faker->sentence(),
            'Coordenadas' => $this->faker->numberBetween($int1 = 0, $int2 = 99999),
            'valor' => $this->faker->randomFloat(2, 10, 1000),
            'Obs' => $this->faker->sentence(),
            'tipos_de_produto_id' => function() {
                return TipoProduto::factory()->create()->id;
            },
            'destino_id' =>function() {
                return Destino::factory()->create()->id;
            }
        ];
    }
}
