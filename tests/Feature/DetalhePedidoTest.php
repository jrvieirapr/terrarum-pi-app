<?php

namespace Tests\Feature;

use App\Models\DetalhePedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DetalhePedidoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

public function ListarTodosDetalhesPedidos () {
    
    //Criar 5 tipos
    //Salvar Temporario
    DetalhePedido::factory()->count(5)->create();

    // usar metodo GET para verificar o retorno
    $response = $this->getJson('/api/detalhespedidos');

    //Testar ou verificar saida
    $response->assertStatus(200)
    ->assertJsonCount(5, 'data')
    ->assertJsonStructure([
     'data' => [
        '*' => ['id', 'descricao', 'data', 'quantidade', 'valor_unitario', 'total' ,'produtos_id', 'eventos_id', 'created_at', 'updated_at']
     ]
     ]);
     }

     /** 
       * Criar um Tipo
       */
      public function testCriarDetalhePedidoSucesso(){      

        //Criar o objeto

        $data = [
        'descricao' => $this->faker->sentence(),
        'data' => $this->faker->randomFloat(2, 10, 1000),
        'quantidade' => $this->faker->numberBetween($int1 = 0, $int2 = 99999),
        'valor_unitario' => $this->faker->numberBetween($int1 = 0, $int2 = 99999),
        'total' => $this->faker->numberBetween($int1 = 0, $int2 = 99999),
        'produto_id' => $produto->id
        'evento_id' => $eventos->id

      ];

        //Debug
        //dd($data);

        // Fazer uma requisicao POST
        $response = $this->postJson('/api/detalhespedido', $data);

        //dd($response);

        // Verifique se teve um retorno 201 - Criado com sucesso
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(201)
        ->assertJsonStructure(['id', 'descricao', 'data','quantidade', 'valor_unitario', 'total', 'created_at', 'updated_at']);
     }

      /**
       * Teste de criacao com falhas
       * 
       * @return void
       */
      public function testCriacaoDetalhePedidoFalha()
      {
         $data = [
         "descricao" => 'a',
         "data" => '',
         "quantidade" => '',
         "valor_unitario" => '',
         "total" => '',
         "produto_id" => '',
         "evento_id" => '',
         ];

         // Fazer uma requisição POST
         $response = $this->postJson('/api/detalhespedidos', $data);

         // Verifique se teve um retorno 422 - Falha no salvamento
         // e se a estrutura do JSON Corresponde
         $response->assertStatus(422)
         ->assertJsonValidationErrors([, 'descricao', 'data', 'quantidade', 'valor_unitario', 'total', 'produto_id', 'evento_id']);
      }

      /** 
       * Teste de pesquisa de registro
       *
       * @return void 
       */ 

        public function testPesquisaDetalhePedidoSucesso()
      {
         // Criar um produto
         $detalhepedido = DetalhePedido::factory()->create();

         // Fazer pesquisa
         $response = $this->getJson('/api/detalhespedidos/' . $produto->id);
 
         // Verificar saida
         $response->assertStatus(200)
             ->assertJson([
                 'id' => $detalhepedido->id,
                 'descricao' => $detalhepedido->descricao,
                 'data' => $detalhepedido->data,
                 'quantidade' => $detalhepedido->quantidade,
                 'valor_unitario' =>$detalhepedido->valor_unitario,
                 'total' =>$detalhepedido->total,
                 'produto_id' => $detalhepedido->produto_id,

             ]);

            }
      /**
       * Teste de upgrade com sucesso
       * 
       *  @return void
       */
      public function testUpdateDetalhePedidoComFalhas()
      {
         // Crie um tipo fake
         $detalhespedidos = DetalhePedido::factory()->create();

         // Dados para update
         $invalidData = [
            'descricao' => ' ',
            'data' => ' ',
            'quantidade' => ' ',
            'valor_unitario' => ' ',
            'total' => ' ',
            'produto_id' => ' ',
            'evento_id' => ' ',
            
          
         ];

         // Faca uma chamada PUT
         $response = $this->putJson('/api/detalhespedidos/' . $produto->id, $invalidData);

         // Verificar se teve um erro 422
         $response->assertStatus(422)
         ->assertJsonValidationErrors(['descricao', 'data', 'quantidade', 'valor_unitario', 'total', 'produto_id', 'evento_id']);

      }

      /**
       * Testando com falhas
       * 
       * @return void
       */
      public function testUpdateDetalhePedidoDataInvalida()
      {
         // Crie um produto falso
         $detalhepedido = DetalhePedido::factory()->create();

         // Crie dados falhos
         $invalidData = [
            
            'descricao' => 'a',
            'data' => 'a',
            'quantidade' => 'a',
            'valor_unitario' => ' ',
            'total' => ' ',
            'produto_id' => ' ',
            'evento_id' => ' ',
          
         ];
         // faca uma chamada PUT
         $response = $this->putJson('/api/produtos/' . $produto->id, $invalidData);

         // Verificar se teve um erro 422
         $response->assertStatus(422)
         ->assertJsonValidationErrors([, 'descricao', 'data', 'quantidade', 'valor_unitario', 'total', 'produto_id', 'evento_id', ]);

      }
      /**
       * Teste update de marca
       * 
       * @return void
       */
      public function testUpdateDetalhePedidoNaoExistente()
      {
         // Criar um tipo usando um factory

         $detalhepedido = DetalhePedido::factory()->create();

        //Dados para update
        $newData = [

            'descricao' => 'fgtyrrg',
            'data' => '25',
            'quantidade'=> 5 ,
            'valor_unitario' => '456',
            'total' => '5678',
            'produto_id' => $detalhepedido->produto->id,
            'evento-id' => $detalhepedido->evento->id,
            
          ];
          $response = $this->putJson('api/detalhespedidos/999', $newData);

          // Verificar o retorno 404
          $response->assertStatus(404)
          ->assertJson([
             'message' => 'Produto não encontrado',
 
          ]);
 
         }
         /**
          * Teste de deletar com sucesso
          *
          * @return void
          */
         public function testDeleteDetalhePedido()
         {
             // Criar produto fake
             $detalhepedido = DetalhePedido::factory()->create();
        
             // enviar requisição para Delete
             $response = $this->deleteJson('/api/detalhespedidos/' . $detalhepedido $->id);
        
             // Verifica o Detele
             $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Produto deletado com sucesso!'
                 ]);
        
             //Verifique se foi deletado do banco
             $this->assertDatabaseMissing('detalhespedidos', ['id' => $detalhepedido->id]);
         }
      }
        
      