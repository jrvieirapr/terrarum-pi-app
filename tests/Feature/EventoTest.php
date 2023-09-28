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
      ->assertJsonStructure(['id', 'Nome', 'Descricao', 'Coordenadas', 'valor', 'Obs', 'tipos_de_produto_id', 'destino_id', 'created_at', 'updated_at']);
  }

  //CRIAR EVENTO (FALHA)
  public function testCriacaoEventoFalha()
  {
    $data = [
      'Nome' => '',
      'Descricao' => '',
      'Coordenadas' => '',
      'valor' => '',
      'Obs' => '',
      'tipos_de_produto_id' => '',
      'destino_id' => ''
    ];
    $response = $this->postJson('/api/eventos', $data);
    $response->assertStatus(422)
      ->assertJsonValidationErrors(['Nome', 'Descricao', 'Coordenadas', 'valor', 'Obs', 'tipos_de_produto_id', 'destino_id']);
  }

  //PESQUISAR EVENTO (SUCESSO)
  public function testPesquisaEventoSucesso()
  {
    $evento = Evento::factory()->create();
    $response = $this->getJson('/api/eventos/' . $evento->id);
    $response->assertStatus(200)
      ->assertJson([
        'id' => $evento->id,
        'Nome' => $evento->Nome,
        'Descricao' => $evento->Descricao,
        'Coordenadas' => $evento->Coordenadas,
        'valor' => $evento->valor,
        'Obs' => $evento->Obs,
        'tipos_de_produto_id' => $evento->tipos_de_produto_id,
        'destino_id' => $evento->destino_id
      ]);
  }

  //PESQUISAR EVENTO (FALHA)
  public  function testPesquisaEventoFalha()
  {
    $response = $this->getJson('/api/eventos/999');
    $response->assertStatus(404)
      ->assertJson([
        'message' => "Evento não encontrado"
      ]);
  }

  //ATUALIZAR UM EVENTO (SUCESSO)
  public function testUpdateEventoSucesso()
  {
    $evento = Evento::factory()->create();

    // Dados para update
    $newData = [
      'Nome' => 'fbgdn',
      'Descricao' => 'fshgnhfmn',
      'Coordenadas' => '11223443',
      'valor' => 23234,
      'Obs' => 'gghjkjlk',
      'tipos_de_produto_id' => $evento->tipos_de_produto_id,
      'destino_id' => $evento->destino_id
    ];



    // Faça uma chamada PUT
    $response = $this->putJson('/api/eventos/' . $evento->id, $newData);

    // Verifique a resposta
    $response->assertStatus(200)
      ->assertJson([
        'id' => $evento->id,
        'Nome' => 'fbgdn',
        'Descricao' => 'fshgnhfmn',
        'Coordenadas' => '11223443',
        'valor' => 23234,
        'Obs' => 'gghjkjlk',
        'tipos_de_produto_id' => $evento->tipos_de_produto_id,
        'destino_id' => $evento->destino_id
      ]);
  }

  //ATUALIZAR UM EVENTO (SUCESSO)
  public function testUpdateEventoComFalhas()
  {
    $evento = Evento::factory()->create();
    $invalidData = [
      'Nome' => '',
      'Descricao' => '',
      'Coordenadas' => '',
      'valor' => '',
      'Obs' => '',
      'tipos_de_produto_id' => '',
      'destino_id' => ''
    ];
    $response = $this->putJson('/api/eventos/' . $evento->id, $invalidData);
    $response->assertStatus(422)
      ->assertJsonValidationErrors(['Nome', 'Descricao', 'Coordenadas', 'valor', 'Obs', 'tipos_de_produto_id', 'destino_id']);
  }

  //ATUALIZAR UM EVENTO NÃO EXISTENTE
  public function testUpdateEventoNaoExistente()
  {
    $evento = Evento::factory()->create();
    $newData = [
      'id' => $evento->id,
      'Nome' => 'fbgdn',
      'Descricao' => 'fshgnhfmn',
      'Coordenadas' => '11223443',
      'valor' => 23234,
      'Obs' => 'gghjkjlk',
      'tipos_de_produto_id' => $evento->tipos_de_produto_id,
      'destino_id' => $evento->destino_id
    ];
    $response = $this->putJson('/api/eventos/9999', $newData);
    $response->assertStatus(404)
      ->assertJson([
        'message' => 'Evento não encontrado'
      ]);
  }

  //ATUALIZAR UM EVENTO COM MESMO NOME
public function testUpdateEventoMesmoNome() {
  $evento = Evento::factory()->create();
  $sameData = [
      'Nome' => $evento->Nome,
      'Descricao' => $evento->Descricao,
      'Coordenadas' => $evento->Coordenadas,
      'valor' => $evento->valor,
      'Obs' => $evento->Obs,
      'tipos_de_produto_id' => $evento->tipos_de_produto_id,
      'destino_id' => $evento->destino_id
  ];

  $response = $this->putJson('/api/eventos/'. $evento->id, $sameData);
  $response->assertStatus(200)
      ->assertJson([
       'id' => $evento->id,
      'Nome' => $evento->Nome,
      'Descricao' => $evento->Descricao,
      'Coordenadas' => $evento->Coordenadas,
      'valor' => $evento->valor,
      'Obs' => $evento->Obs,
      'tipos_de_produto_id' => $evento->tipos_de_produto_id,
      'destino_id' => $evento->destino_id
      ]);
}

 //PESQUISAR EVENTO COM NOME DUPLICADO
 public function testEventoNomeDuplicado() {
  $evento = Evento::factory()->create();
  $atualizar = Evento::factory()->create();
  $sameData = [
      'Nome' => $evento->Nome,
      'Descricao' => $evento->Descricao,
      'Coordenadas' => $evento->Coordenadas,
      'valor' => $evento->valor,
      'Obs' => $evento->Obs,
      'tipos_de_produto_id' => $evento->tipos_de_produto_id,
      'destino_id' => $evento->destino_id
  ];
  $response = $this->putJson('/api/eventos/'. $atualizar->id, $sameData);
  $response->assertStatus(422)
      ->assertJsonValidationErrors(['Nome']);
}

// DELETAR EVENTO
public function testDeleteEvento()
 {
     // Criar evento fake
     $evento = Evento::factory()->create();

     // enviar requisição para Delete
     $response = $this->deleteJson('/api/eventos/' . $evento->id);

     // Verifica o Delete
     $response->assertStatus(200)
         ->assertJson([
             'message' => 'Evento deletado com sucesso!'
         ]);

     //Verifique se foi deletado do banco
     $this->assertDatabaseMissing('eventos', ['id' => $evento->id]);
  }

public function testDeleteEventotoNaoExistente() {
    $response = $this->deleteJson('/api/eventos/999');
    $response->assertStatus(404)
        ->assertJson([
            'message' => 'Evento não encontrado!'
        ]);
}

}