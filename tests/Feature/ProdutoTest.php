<?php

namespace Tests\Feature;

use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    /**Listar todos os Produtos
     * @return void
     */

    public function testListarTodosProdutos()
    {
        //Criar 5 Pedidos
        //Salvar Temporario
        Produto::factory()->count(5)->create();

        // usar metodo GET para verificar o retorno
        $response = $this->getJson('/api/produtos/');

        //Testar ou verificar saida
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'tipo', 'destino_id', 'tipos_de_produtos_id', 'esta_ativo', 'created_at', 'updated_at']
                ]
            ]);
    }   

}

