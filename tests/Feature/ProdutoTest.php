<?php

namespace Tests\Feature;

use App\Models\Destino;
use App\Models\DetalhePedido;
use App\Models\Produto;
use App\Models\TipoProduto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A função index deve retornar 5 cadastros
     *
     * @return void
     */
    public function test_funcao_index_retornar_array_produto_com_sucesso()
    {
        // Criar parâmetros
        $produtos = Produto::factory()->count(5)->create();

        // Usar verbo GET
        $response = $this->getJson('/api/produtos/');
        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id', 'descricao', 'esta_ativo', 'tipo_produto_id', 'destino_id',
                            'created_at', 'updated_at'
                        ]
                    ]
                ]
            );
    }

    /**
     * Deve cadastrar um novo registro com sucesso
     * @return void
     */
    public function test_criar_um_novo_produto_com_sucesso()
    {
        // Criar Tipo de Produto e Destino
        $tipoProduto = TipoProduto::factory()->create();
        $destino = Destino::factory()->create();

        // Criar dados
        $data = [
            'descricao' => $this->faker->word(),
            'esta_ativo' => true,
            'tipo_produto_id' => $tipoProduto->id,
            'destino_id' => $destino->id,
        ];

        // Processar
        $response = $this->postJson('/api/produtos/', $data);

        // Avaliar a saída
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'descricao', 'esta_ativo', 'tipo_produto_id', 'destino_id',
                'created_at', 'updated_at'
            ]);
    }

    /**
     * Deve cadastrar um novo registro com falha
     * @return void
     */
    public function test_criar_um_novo_produto_com_falha()
    {
        // Criar dados com campos em branco
        $data = [
            'descricao' => "",
            'esta_ativo' => "",
            'tipo_produto_id' => "",
            'destino_id' => "",
        ];

        // Processar
        $response = $this->postJson('/api/produtos/', $data);

        // Avaliar a saída
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'descricao', 'esta_ativo', 'tipo_produto_id', 'destino_id'
            ]);
    }

    /**
     * Buscar um ID no servidor com sucesso!
     * @return void
     */
    public function test_buscar_id_no_banco_com_sucesso()
    {
        // Criar dados
        $produto = Produto::factory()->create();

        // Processar
        $response = $this->getJson('/api/produtos/' . $produto->id);

        // Verificar saída
        $response->assertStatus(200)
            ->assertJson([
                'id' => $produto->id,
                'descricao' => $produto->descricao,
                'esta_ativo' => $produto->esta_ativo,
                'tipo_produto_id' => $produto->tipo_produto_id,
                'destino_id' => $produto->destino_id
            ]);
    }

    /**
     * Deve dar erro ao tentar pesquisar um cadastro inexistente
     * @return void
     */
    public function test_buscar_id_no_banco_com_falha()
    {
        // Processar
        $response = $this->getJson('/api/produtos/99999999');

        // Verificar saída
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Produto não encontrado!"
            ]);
    }

    /**
     * Teste de atualização com sucesso
     * @return void
     */

    public function test_atualizar_produto_com_sucesso()
    {
        // Criar dados
        $produto = Produto::factory()->create();
        $tipoProduto = TipoProduto::factory()->create();
        $destino = Destino::factory()->create();

        // Novos dados
        $new = [
            'descricao' => $this->faker->word(),
            'esta_ativo' => false,
            'tipo_produto_id' => $tipoProduto->id,
            'destino_id' => $destino->id,
        ];

        // Processar
        $response = $this->putJson('/api/produtos/' . $produto->id, $new);

        // Analisar
        $response->assertStatus(200)
            ->assertJson([
                'id' => $produto->id,
                'descricao' => $new['descricao'],
                'esta_ativo' => $new['esta_ativo'],
                'tipo_produto_id' => $new['tipo_produto_id'],
                'destino_id' => $new['destino_id'],
            ]);
    }

    /**
     * Teste de atualização com falha no ID
     * @return void
     */

    public function test_atualizar_produto_com_falha_no_id()
    {
        // Criar dados
        $new = [
            'descricao' => $this->faker->word(),
            'esta_ativo' => false,
            'tipo_produto_id' => TipoProduto::factory()->create()->id,
            'destino_id' => Destino::factory()->create()->id,
        ];

        // Processar
        $response = $this->putJson('/api/produtos/999999999', $new);

        // Analisar
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Produto não encontrado!",
            ]);
    }

    /**
     * Teste de atualização com falha nos dados
     * @return void
     */

    public function test_atualizar_produto_com_falha_nos_dados()
    {
        // Criar dados
        $produto = Produto::factory()->create();

        // Novos dados com campos em branco
        $new = [
            'descricao' => "",
            'esta_ativo' => "",
            'tipo_produto_id' => "",
            'destino_id' => "",
        ];

        // Processar
        $response = $this->putJson('/api/produtos/' . $produto->id, $new);

        // Analisar
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'descricao', 'esta_ativo', 'tipo_produto_id', 'destino_id'
            ]);
    }

    /**
     * Deletar com Sucesso
     * @return void
     */

    public function test_deletar_com_sucesso()
    {
        // Criar dados
        $produto = Produto::factory()->create();

        // Processar
        $response = $this->deleteJson('/api/produtos/' . $produto->id);

        // Analisar
        $response->assertStatus(200)
            ->assertJson([
                'message' => "Produto deletado com sucesso!",
            ]);
    }

    /**
     * Teste de remover com falha no ID
     * @return void
     */

    public function test_remover_produto_com_falha_no_id()
    {
        // Processar
        $response = $this->deleteJson('/api/produtos/999999999');

        // Analisar
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Produto não encontrado!",
            ]);
    }

    /**
     * Deve dar erro ao tentar deletar um produto com detalhes de pedidos dependentes
     */
    public function test_deletar_produto_com_detalhes_pedidos_dependentes()
    {
        // Crie um produto
        $produto = Produto::factory()->create();

        // Crie um detalhe de pedido dependente associado ao produto
        DetalhePedido::factory()->create(['produto_id' => $produto->id]);

        // Tente excluir o produto
        $response = $this->deleteJson('/api/produtos/' . $produto->id);

        // Verifique a resposta
        $response->assertStatus(422)
            ->assertJson([
                'message' => "Não é possível excluir o produto, pois existem detalhes de pedidos dependentes associados a ele."
            ]);
    }
}
