<?php

namespace Tests\Feature;

use App\Models\DetalhePedido;
use App\Models\Evento;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function test_listar_pedidos_com_detalhes_pedido()
    {
        // Crie alguns pedidos e detalhes do pedido fictícios no banco de dados
        $pedidos = Pedido::factory(3)->create();

        foreach ($pedidos as $pedido) {
            DetalhePedido::factory(2)->create(['pedido_id' => $pedido->id]);
        }

        // Faça uma solicitação GET para listar os pedidos
        $response = $this->getJson('/api/pedidos');

        // Verifique se a resposta está correta
        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(3, 'data') // Verifica se há 3 pedidos na resposta
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'data', 'numero', 'usuario_id', 'created_at', 'updated_at',
                        'detalhes_pedido' => [
                            '*' => [
                                'id', 'evento_id', 'produto_id', 'descricao', 'quantidade',
                                'valor_unitario', 'valor_total', 'created_at', 'updated_at',
                            ],
                        ],
                    ],
                ],
            ]);

        // Verificar se os dados dos pedidos e detalhes do pedido correspondem aos criados no banco de dados
        foreach ($pedidos as $pedido) {
            $response->assertJsonFragment([
                'id' => $pedido->id,
                'data' => $pedido->data,
                'numero' => $pedido->numero,
                'usuario_id' => $pedido->usuario_id,
            ]);

            foreach ($pedido->detalhesPedido as $detalhe) {
                $response->assertJsonFragment([
                    'id' => $detalhe->id,
                    'evento_id' => $detalhe->evento_id,
                    'produto_id' => $detalhe->produto_id,
                    'descricao' => $detalhe->descricao,
                    'quantidade' => $detalhe->quantidade,
                    'valor_unitario' => $detalhe->valor_unitario,
                    'valor_total' => $detalhe->valor_total,
                ]);
            }
        }
    }


    public function test_criar_um_novo_pedido_com_detalhes_pedido_com_sucesso()
    {
        // Criar um usuário
        $usuario = Usuario::factory()->create();

        // Criar detalhes de pedido de exemplo
        $detalhesPedidoData = [];
        for ($i = 0; $i < 3; $i++) {
            $detalhesPedidoData[] = [
                'evento_id' => Evento::factory()->create()->id,
                'produto_id' => Produto::factory()->create()->id,
                'descricao' => $this->faker->word(),
                'valor' => $this->faker->randomFloat(2, 0, 100),
                'data' => $this->faker->date,
                'quantidade' => $this->faker->randomNumber(2),
                'valor_unitario' => $this->faker->randomFloat(2, 0, 100),
                'valor_total' => $this->faker->randomFloat(2, 0, 100),
            ];
        }

        // Dados do pedido
        $pedidoData = [
            'data' => $this->faker->date,
            'numero' => $this->faker->unique()->randomNumber(5),
            'esta_ativo' => true,
            'usuario_id' => $usuario->id,
            'detalhes_pedido' => $detalhesPedidoData,
        ];

        // Enviar uma solicitação POST para criar o pedido
        $response = $this->postJson('/api/pedidos', $pedidoData);

        // Verificar se a resposta está correta e o pedido foi criado
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'data', 'numero', 'esta_ativo', 'usuario_id',
                'created_at', 'updated_at', 'detalhes_pedido' => [
                    '*' => [
                        'evento_id', 'produto_id', 'descricao',
                        'quantidade', 'valor_unitario', 'valor_total',
                    ],
                ],
            ]);

        // Verificar se os detalhes do pedido estão corretos
        $this->assertCount(3, $response['detalhes_pedido']);

        // Verificar se os dados do pedido estão corretos no banco de dados
        $this->assertDatabaseHas('pedidos', [
            'data' => $pedidoData['data'],
            'numero' => $pedidoData['numero'],
            'esta_ativo' => $pedidoData['esta_ativo'],
            'usuario_id' => $pedidoData['usuario_id'],
        ]);

        // Verificar se os detalhes do pedido estão corretos no banco de dados
        foreach ($detalhesPedidoData as $detalhe) {
            $this->assertDatabaseHas('detalhes_pedidos', [
                'evento_id' => $detalhe['evento_id'],
                'produto_id' => $detalhe['produto_id'],
                'descricao' => $detalhe['descricao'],
                'quantidade' => $detalhe['quantidade'],
                'valor_unitario' => round($detalhe['valor_unitario'], 2),
                'valor_total' => round($detalhe['valor_total'], 2),
            ]);
        }
    }

    public function test_mostrar_pedido_existente()
    {
        // Crie um pedido de exemplo no banco de dados
        $pedido = Pedido::factory()->create();

        // Faça uma solicitação GET para mostrar o pedido
        $response = $this->get('/api/pedidos/' . $pedido->id);

        // Verifique se a resposta tem o status HTTP 200 (OK)
        $response->assertStatus(200);

        // Verifique se a resposta contém os dados do pedido
        $response->assertJson([
            'id' => $pedido->id,
            'data' => $pedido->data,
            'numero' => $pedido->numero,
            'esta_ativo' => $pedido->esta_ativo,
            'usuario_id' => $pedido->usuario_id,
            // Inclua outros campos conforme necessário
        ]);
    }

    public function test_mostrar_pedido_nao_encontrado()
    {
        // Tente buscar um pedido com um ID que não existe
        $response = $this->get('/api/pedidos/9999');

        // Verifique se a resposta tem o status HTTP 404 (Não encontrado)
        $response->assertStatus(404);

        // Verifique se a resposta contém a mensagem de erro
        $response->assertJson([
            'message' => 'Pedido não encontrado',
        ]);
    }

    public function test_atualizar_pedido_com_sucesso()
    {
        // Crie um pedido existente
        $pedido = Pedido::factory()->create();

        // Crie detalhes do pedido específicos para este pedido
        $novosDetalhes = [
            [
                'evento_id' => Evento::factory()->create()->id,
                'produto_id' => Produto::factory()->create()->id,
                'descricao' => 'Nova descrição',
                'quantidade' => 3,
                'valor_unitario' => 5.99,
                'valor_total' => 17.97,
            ],
        ];

        $data = [
            'data' => '2023-10-01',
            'numero' => '123456',
            'esta_ativo' => true,
            'usuario_id' => Usuario::factory()->create()->id,
            'detalhes_pedido' => $novosDetalhes,
        ];

        // Faça uma solicitação PUT para atualizar o pedido
        $response = $this->putJson('/api/pedidos/' . $pedido->id, $data);

        // Verifique se a resposta tem o status HTTP 200 (OK)
        $response->assertStatus(200);

        // Verifique se os dados do pedido foram atualizados corretamente no banco de dados
        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'data' => '2023-10-01',
            'numero' => '123456',
            'esta_ativo' => true,
            'usuario_id' => $data['usuario_id'],
        ]);

        // Verifique se os detalhes do pedido foram atualizados corretamente no banco de dados
        foreach ($novosDetalhes as $detalhe) {
            $this->assertDatabaseHas('detalhes_pedidos', [
                'pedido_id' => $pedido->id,
                'evento_id' => $detalhe['evento_id'],
                'produto_id' => $detalhe['produto_id'],
                'descricao' => $detalhe['descricao'],
                'quantidade' => $detalhe['quantidade'],
                'valor_unitario' => $detalhe['valor_unitario'],
                'valor_total' => $detalhe['valor_total'],
            ]);
        }
    }

    public function test_atualizar_pedido_que_nao_existe()
    {
        $usuario = Usuario::factory()->create();

        // Dados de exemplo para atualizar o pedido
        $data = [
            'data' => '2023-10-26',
            'numero' => 12345,
            'esta_ativo' => false,
            'usuario_id' => $usuario->id,
            'detalhes_pedido' => [
                [
                    'evento_id' => Evento::factory()->create()->id,
                    'produto_id' => Produto::factory()->create()->id,
                    'descricao' => 'Descrição atualizada',
                    'quantidade' => 3,
                    'valor_unitario' => 5.99,
                    'valor_total' => 17.97,
                ],
                // Adicione mais detalhes do pedido, se necessário
            ],
        ];
        // Tente atualizar um pedido que não existe (use um ID que não existe)
        $response = $this->putJson('/api/pedidos/999', $data);

        // Verifique se a resposta tem o status HTTP 404 (Not Found)
        $response->assertStatus(404);
    }

    public function testDestroyPedido()
    {
        // Crie um pedido e detalhes do pedido associados
        $pedido = Pedido::factory()->create();
        $detalhesPedido = DetalhePedido::factory(3)->create(['pedido_id' => $pedido->id]);

        // Execute a rota de exclusão do pedido
        $response = $this->deleteJson('/api/pedidos/' . $pedido->id);

        // Verifique se a resposta tem o status HTTP 200 (OK)
        $response->assertStatus(200);

        // Verifique se a mensagem de sucesso está presente na resposta
        $response->assertJson(['message' => 'Pedido deletado com sucesso!']);

        // Verifique se o pedido foi excluído do banco de dados
        $this->assertDatabaseMissing('pedidos', ['id' => $pedido->id]);

        // Verifique se os detalhes do pedido foram excluídos do banco de dados
        foreach ($detalhesPedido as $detalhe) {
            $this->assertDatabaseMissing('detalhes_pedidos', ['id' => $detalhe->id]);
        }
    }

    public function testDestroyPedidoNotFound()
    {
        // Tente excluir um pedido que não existe
        $response = $this->deleteJson('/api/pedidos/999');

        // Verifique se a resposta tem o status HTTP 404 (Não encontrado)
        $response->assertStatus(404);

        // Verifique se a mensagem de erro está presente na resposta
        $response->assertJson(['message' => 'Pedido não encontrado!']);
    }
}
