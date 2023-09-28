<?php

namespace Tests\Feature;

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
}
public function ListarTodosDetalhesPedidos () {
    
    //Criar 5 tipos
    //Salvar Temporario
    TipoProduto::factory()->count(5)->create();

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

           "descricao" => $this->faker->word
           'data' => 
           'quantidade'=>
           'valor_unitario'=>
           'total'=>
        ];

        //Debug
        //dd($data);

        // Fazer uma requisicao POST
        $response = $this->postJson('/api/tiposprodutos', $data);

        //dd($response);

        // Verifique se teve um retorno 201 - Criado com sucesso
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(201)
        ->assertJsonStructure(['id', 'descricao', 'created_at', 'updated_at']);
     }



