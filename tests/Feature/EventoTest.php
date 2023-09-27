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
  public function testListarTodosEventos()
  {
    Evento::factory()->count(5)->create();
    $response = $this->getJson('/api/eventos');
    $response->assertStatus(200)
      ->assertJsonCount(5, 'data')
      ->assertJsonStructure([
        'data' => [
          '*' => ['Nome', 'Descricao', 'Coordenadas', 'valor', 'Obs', 'tipos_de_produto_id', 'destino_id', 'created_at', 'updated_at']
        ]
      ]);
  }

  // CRIAR EVENTO (SUCESSO)
  public function testCriarEventoSucesso()
  {
    $tipo = TipoProduto::factory()->create()->id;
    $destino = Destino::factory()->create()->id;
    $data = [
      'Nome' => '' . $this->faker->word . '' .
        $this->faker->numberBetween($int1 = 0, $int2 = 99999),
      'Descricao' => $this->faker->sentence(),
      'Coordenadas' => $this->faker->numberBetween($int1 = 0, $int2 = 99999),
      'valor' => $this->faker->randomFloat(2, 10, 1000),
      'Obs' => $this->faker->sentence(),
      'tipos_de_produto_id' => $tipo,
      
      'destino_id' => $destino,
     
    ];
    // dd($data);
    $response = $this->postJson('/api/eventos', $data);
    //dd($response);
    $response->assertStatus(201)
      ->assertJsonStructure(['id','Nome', 'Descricao', 'Coordenadas', 'valor', 'Obs', 'tipos_de_produto_id', 'destino_id', 'created_at', 'updated_at']);
  }

  public function testCriacaoProdutoFalha() {
    $data = [
      'Nome', 'Descricao', 'Coordenadas', 'valor', 'Obs', 'tipos_de_produto_id',
      'destino_id'
    ];
    $response = $this->postJson('/api/produtos',$data);
    $response->assertStatus(422)
    ->assertJsonValidationErrors(['Nome', 'Descricao', 'Coordenadas', 'valor', 'Obs', 'tipos_de_produto_id', 'destino_id']);
 }   
}
