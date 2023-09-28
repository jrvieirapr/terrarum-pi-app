<?php

namespace Tests\Feature;

use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

  //LISTAR TODOS OS PEDIDOS
  public function testListarTodosEventos()
  {
    Pedido::factory()->count(5)->create();
    $response = $this->getJson('/api/pedidos');
    $response->assertStatus(200)
      ->assertJsonCount(5, 'data')
      ->assertJsonStructure([
        'data' => [
          '*' => ['data','produto','quant','preco','total','obs','usuario_id','detalhes_pedido_id', 'created_at', 'updated_at']
        ]
      ]);
  }

}
