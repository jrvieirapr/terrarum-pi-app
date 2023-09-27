<?php

namespace Tests\Feature;

use App\Models\Destino;
use App\Models\Evento;
use App\Models\TipoProduto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventoTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  //LISTAR TODOS OS EVENTOS
  public function testListarTodosEventos() {
    Evento::factory()->count(5)->create();
    $response = $this->getJson('/api/eventos');
    $response->assertStatus(200)
    ->assertJsonCount(5,'data')
    ->assertJsonStructure([
      'data'=> [
        '*'=> ['Nome', 'Tipo','Descricao','Coordenadas','valor','Obs', 'tipoproduto_id','destino_id','created_at','updated_at']
      ]
      ]);
  }

  //CRIAR UM EVENTO (SUCESSO)
  public function testCriarEventoSucesso() {
  $tipo = TipoProduto::factory()->create();
  $destino = Destino::factory()->create();
  $data = [
    'Nome' =>''.$this->faker->word.''.
      $this->faker->numberBetween($int1 = 0 , $int2 = 99999),
    'Tipo' => ''.$this->faker->word.''.
      $this->faker->numberBetween($int1 = 0 , $int2 = 99999),
    'Descricao' => $this->faker->sentence(),
    'Coordenadas' => $this->faker->numberBetween($int1 = 0, $int2 = 99999),
    'valor' => $this->faker->randomFloat(2, 10, 1000),
    'Obs' => $this->faker->sentence(),
    'tipoproduto_id' => function() {
       return TipoProduto::factory()->create()->id;
      },
    'destino_id' =>function() {
      return Destino::factory()->create()->id;
    },
  ];
  $response = $this->postJson('/api/eventos', $data);
  $response->asseretStatus(201)
  ->assertJsonStructure(['Nome', 'Tipo','Descricao','Coordenadas','valor','Obs', 'tipoproduto_id','destino_id','created_at','updated_at']);
  }


