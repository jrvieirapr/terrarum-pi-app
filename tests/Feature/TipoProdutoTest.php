<?php

namespace Tests\Feature;

use App\Models\TipoProduto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TipoProdutoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A função index deve retornar 5 cadastros.
     *
     * @return void
     */
    public function test_funcao_index_retornar_array_tipos_com_sucesso()
    {
        //Criar tipos de produtos
        TipoProduto::factory()->count(5)->create();

        //Fazer uma chamada para a rota index no API
        $response = $this->getJson('/api/tipo_produtos/');

        //Verificar resposta
        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'descricao', 'created_at', 'updated_at'],
                ],
            ]);
    }

    /**
     * Deve cadastrar um novo registro com sucesso.
     *
     * @return void
     */
    public function test_criar_um_novo_tipo_produto_com_sucesso()
    {
        //Criar dados
        $data = [
            'descricao' => $this->faker->unique()->word,
        ];

        //Processar
        $response = $this->postJson('/api/tipo_produtos/', $data);

        //Avaliar a saída
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'descricao', 'created_at', 'updated_at',
            ]);
    }

    /**
     * Deve cadastrar um novo registro com falha de descrição duplicada.
     *
     * @return void
     */
    public function test_criar_um_novo_tipo_produto_com_falha_descricao_duplicada()
    {
        //Criar um tipo de produto existente
        $tipoProduto = TipoProduto::factory()->create();

        //Criar dados com a mesma descrição
        $data = [
            'descricao' => $tipoProduto->descricao,
        ];

        //Processar
        $response = $this->postJson('/api/tipo_produtos/', $data);

        //Avaliar a saída
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['descricao']);
    }

    /**
     * Deve buscar um ID no servidor com sucesso.
     *
     * @return void
     */
    public function test_buscar_id_no_banco_com_sucesso()
    {
        //Criar um tipo de produto
        $tipoProduto = TipoProduto::factory()->create();

        //Processar
        $response = $this->getJson('/api/tipo_produtos/' . $tipoProduto->id);

        //Verificar saída
        $response->assertStatus(200)
            ->assertJson([
                'id' => $tipoProduto->id,
                'descricao' => $tipoProduto->descricao,
            ]);
    }

    /**
     * Deve dar erro ao tentar pesquisar um cadastro inexistente.
     *
     * @return void
     */
    public function test_buscar_id_no_banco_com_falha()
    {
        //Processar
        $response = $this->getJson('/api/tipo_produtos/99999999');

        //Verificar saída
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Tipo não encontrado",
            ]);
    }

    /**
     * Teste de atualização com sucesso.
     *
     * @return void
     */
    public function test_atualizar_tipo_produto_com_sucesso()
    {
        //Criar um tipo de produto
        $tipoProduto = TipoProduto::factory()->create();

        //Criar novos dados
        $data = [
            'descricao' => $this->faker->unique()->word,
        ];

        //Processar
        $response = $this->putJson('/api/tipo_produtos/' . $tipoProduto->id, $data);

        //Verificar saída
        $response->assertStatus(200)
            ->assertJson([
                'id' => $tipoProduto->id,
                'descricao' => $data['descricao'],
            ]);
    }

    /**
     * Teste de atualização com falha no ID.
     *
     * @return void
     */
    public function test_atualizar_tipo_produto_com_falha_no_id()
    {
        //Criar novos dados
        $data = [
            'descricao' => $this->faker->unique()->word,
        ];

        //Processar
        $response = $this->putJson('/api/tipo_produtos/999999999', $data);

        //Verificar saída
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Tipo não encontrado",
            ]);
    }

    /**
     * Teste de atualização com falha na descrição duplicada.
     *
     * @return void
     */
    public function test_atualizar_tipo_produto_com_falha_descricao_duplicada()
    {
        //Criar dois tipos de produto
        $tipoProduto1 = TipoProduto::factory()->create();
        $tipoProduto2 = TipoProduto::factory()->create();

        //Tentar atualizar o segundo com a descrição do primeiro
        $data = [
            'descricao' => $tipoProduto1->descricao,
        ];

        //Processar
        $response = $this->putJson('/api/tipo_produtos/' . $tipoProduto2->id, $data);

        //Verificar saída
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['descricao']);
    }

    /**
     * Deletar com sucesso.
     *
     * @return void
     */
    public function test_deletar_com_sucesso()
    {
        //Criar um tipo de produto
        $tipoProduto = TipoProduto::factory()->create();

        //Processar
        $response = $this->deleteJson('/api/tipo_produtos/' . $tipoProduto->id);

        //Verificar saída
        $response->assertStatus(200)
            ->assertJson([
                'message' => "Tipo deletado com sucesso",
            ]);
    }

    /**
     * Teste de remoção com falha no ID.
     *
     * @return void
     */
    public function test_remover_tipo_produto_com_falha_no_id()
    {
        //Processar
        $response = $this->deleteJson('/api/tipo_produtos/999999999');

        //Verificar saída
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Tipo não encontrado",
            ]);
    }
}