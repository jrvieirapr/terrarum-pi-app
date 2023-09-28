<?php

namespace Tests\Feature;

use App\Models\TipoProduto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TipoProdutoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


public function ListarTodosTiposProdutos () {
    
    //Criar 5 tipos
    //Salvar Temporario
    TipoProduto::factory()->count(5)->create();

    // usar metodo GET para verificar o retorno
    $response = $this->getJson('/api/tiposprodutos');

    //Testar ou verificar saida
    $response->assertStatus(200)
    ->assertJsonCount(5, 'data')
    ->assertJsonStructure([
     'data' => [
        '*' => ['id', 'descricao', 'created_at', 'updated_at']
     ]
     ]);
     }

     /** 
       * Criar um Tipo
       */
      public function testCriarTipoProdutoSucesso(){      

        //Criar o objeto

        $data = [

           "descricao" => $this->faker->word
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

     /**
       * Teste de criacao com falhas
       * 
       * @return void
       */
      public function testCriacaoTipoProdutoFalha()
      {
         $data = [
            "descricao" => 'a'
         ];

         // Fazer uma requisição POST
         $response = $this->postJson('/api/tiposprodutos', $data);

         // Verifique se teve um retorno 422 - Falha no salvamento
         // e se a estrutura do JSON Corresponde
         $response->assertStatus(422)
         ->assertJsonValidationErrors(['descricao']);
      }

      /** 
       * Teste de pesquisa de registro
       *
       * @return void 
       */ 
      public function testPesquisaTipoProdutoSucesso()
      {
         // Criar um tipo
         $tipoproduto = TipoProduto::factory()->create();

         // Fazer pesquisa
         $response = $this->getJson('/api/tiposprodutos/' . $tipo_produto->id);

       // Verificar saida
         
      $response->assertStatus(200)
        ->assertJson([
         'id' => $tipo_produto->id,
         'descricao' => $tipo_produto->descricao,

        ]);

      }

      /**
       * Teste de pesquisa de registro com falha
       * 
       *  @return void
       */
      public function testPesquisaTipoProdutoSucessoComFalha()
      {
         // Fazer pesquisa com um id inexistente
         $response = $this->getJson('/api/tiposprodutos/999'); // o 999 nao pode existir

         // Verificar a resposta
         $response->assertStatus(404)
         ->assertJson([
            'message' => 'Tipo não encontrado'

         ]);
      }

      /**
       * Teste de upgrade com sucesso
       * 
       *  @return void
       */
      public function testUpdateTipoProdutoSucesso()
      {
         // Crie um tipo fake
         $tipo_produto= TipoProduto::factory()->create();

         // Dados para update
         $newData = [
            'descricao' => 'TipoProduto Descrição',
         ];

         // Faca uma chamada PUT
         $response = $this->putJson('/api/tiposprodutos/' . $tipo_produto->id, $newData);

         // Verifique a resposta
         $response->assertStatus(200)
         ->assertJson([
             'id' => $tipo_produto->id,
             'descricao' => 'TipoProduto Descrição', 
         ]);
 }
      /**
       * Testando com falhas
       * 
       * @return void
       */
      public function testUpdateTipoProdutoDataInvalida()
      {
         // Crie um tipo falso
         $tipo_produto = TipoProduto::factory()->create();

         // Crie dados falhos
         $invalidData = [
            'descricao' => '', // Invalido: Descricao vazio

         ];
         // faca uma chamada PUT
         $response = $this->putJson('/api/tiposprodutos/' . $tipo_produto->id, $invalidData);

         // Verificar se teve um erro 422
         $response->assertStatus(422)
         ->assertJsonValidationErrors(['descricao']);

      }
      /**
       * Teste update de marca
       * 
       * @return void
       */
      public function testUpdateTipoProdutoNaoExistente()
      {
         // Faça uma chamada para  um id falho
         $response = $this->putJson('api/tipos/999', ['descricao' => 'TipoProduto Descricao']);

         // Verificar o retorno 404
         $response->assertStatus(404)
         ->assertJson([
            'message' => 'Tipo não encontrado',

         ]);

      }
      /**
       * Teste de upgrade com os mesmos dados
       * 
       * @return void
       */
      public function testUpdateTipoProdutoMesmoDados()
      {
         // Crie um tipo fake
         $tipo_produto = TipoProduto::factory()->create();

           // Data para update
        $sameData = [
         'descricao' => $tipo_produto->descricao,            
     ];

     // Faça uma chamada PUT
     $response = $this->putJson('/api/tiposprodutos/' . $tipo_produto->id, $sameData);

     // Verifique a resposta
     $response->assertStatus(200)
         ->assertJson([
            'id' => $tipo_produto->id,
            'descricao' => $tipo_produto->descricao
         ]);
 }

 /**
  * Teste upgrade com nome duplicado
  *
  * @return void
  */
 public function testUpdateTipoProdutoDescricaoDuplicada()
 {
     // Crie dois tipos fakes
     $tipo_produto_Existente = TipoProduto::factory()->create();
     $tipo_produto_Upgrade = TipoProduto::factory()->create();

     // Para para upgrade
     $newData = [
         'descricao' => $tipo_produto_Existente->tipo_produto,            
     ];

     // Faça o put 
     $response = $this->putJson('/api/tiposprodutos/' . $tipo_produto_Upgrade->id, $newData);

     // Verifique a resposta
     $response->assertStatus(422)
         ->assertJsonValidationErrors(['descricao']);
 }


 /**
  * Teste de deletar com sucesso
  *
  * @return void
  */
 public function testDeleteTipoProduto()
 {
     // Criar tipo fake
     $tipo_produto = TipoProduto::factory()->create();

     // enviar requisição para Delete
     $response = $this->deleteJson('/api/tiposprodutos/' . $tipo_produto->id);

     // Verifica o Detele
     $response->assertStatus(200)
         ->assertJson([
             'message' => 'TipoProduto deletado com sucesso!'
         ]);

     //Verifique se foi deletado do banco
     $this->assertDatabaseMissing('tiposprodutos', ['id' => $tipo_produto->id]);
 }

 /**
  * Teste remoção de registro inexistente
  *
  * @return void
  */
 public function testDeleteTipoProdutoNaoExistente()
 {
     // enviar requisição para Delete
     $response = $this->deleteJson('/api/tiposprodutos/999');

     // Verifique a resposta
     $response->assertStatus(404)
         ->assertJson([
             'message' => 'TipoProduto não encontrado!'
         ]);
 }
}










        
     
