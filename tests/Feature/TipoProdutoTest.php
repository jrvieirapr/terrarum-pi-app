<?php

namespace Tests\Feature;

use App\Models\TipoProduto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TipoProdutoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testListarTodosTipoProduto()
    {
        TipoProduto::factory()->count(5)->create();

        // usar metodo GET para verificar o retorno
        $response = $this->getJson('/api/tipos_de_produtos');

        //Testar ou verificar saida
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id','descricao', 'created_at', 'updated_at']

                ]
            ]);
    }   

    
    // /**
    //  * Criar um destino
    //  */
    // public function testCriarTipoProdutoSucesso(){

    //     //Criar o objeto
    //     $data = [
    //         "descricao" => ''
    //         ];

    //     //Debug
    //     //dd($data);

    //     // Fazer uma requisição POST -  para salvar
    //     $response = $this->postJson('/api/tipos_de_produtos', $data);

    //     //dd($response);

    //     // Verifique se teve um retorno 201 - Criado com Sucesso
    //     // e se a estrutura do JSON Corresponde
    //     $response->assertStatus(201)// preciso desse retorno
    //         ->assertJsonStructure(['id', 'descricao', 'created_at', 'updated_at']);// com essas informações

    // }


}
