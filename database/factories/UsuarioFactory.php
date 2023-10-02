<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'cpf_cnpj' => $this->faker->numerify('##############'), // 13 números aleatórios
            'cep' => $this->faker->numerify('#####-###'), // CEP no formato 12345-678
            'numero' =>  (string)$this->faker->randomNumber(3), // Número aleatório de 3 dígitos
            'telefone' => $this->faker->phoneNumber,
            'login' => $this->faker->unique()->userName,
            'senha' => bcrypt('password'), // Substitua 'password' pela senha desejada
            'interesses' => $this->faker->sentence,

        ];
    }
}
