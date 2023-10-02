<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A função index deve retornar 5 cadastros.
     *
     * @return void
     */
    public function test_funcao_index_retornar_array_usuarios_com_sucesso()
    {
        //Criar usuários
        Usuario::factory()->count(5)->create();

        //Fazer uma chamada para a rota index no API
        $response = $this->getJson('/api/usuarios/');

        //Verificar resposta
        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'nome', 'cpf_cnpj', 'cep', 'numero', 'telefone', 'login', 'interesses', 'created_at', 'updated_at'],
                ],
            ]);
    }

    /**
     * Deve cadastrar um novo registro com sucesso.
     *
     * @return void
     */
    public function test_criar_um_novo_usuario_com_sucesso()
    {
        //Criar dados
        $data = [
            'nome' => $this->faker->name,
            'cpf_cnpj' => $this->faker->numerify('##############'), // 13 números aleatórios
            'cep' => $this->faker->numerify('#####-###'), // CEP no formato 12345-678
            'numero' =>  (string)$this->faker->randomNumber(3), // Número aleatório de 3 dígitos
            'telefone' => $this->faker->phoneNumber,
            'login' => $this->faker->userName,
            'senha' => bcrypt('password'), // Substitua 'password' pela senha desejada
            'interesses' => $this->faker->sentence,
        ];

        //Processar
        $response = $this->postJson('/api/usuarios/', $data);

        //Avaliar a saída
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'nome', 'cpf_cnpj', 'cep', 'numero', 'telefone', 'login', 'interesses', 'created_at', 'updated_at',
            ]);
    }

    /**
     * Deve cadastrar um novo registro com falha de CPF/CNPJ duplicado.
     *
     * @return void
     */
    public function test_criar_um_novo_usuario_com_falha_cpf_cnpj_duplicado()
    {
        //Criar um usuário existente
        $usuario = Usuario::factory()->create();

        //Criar dados com o mesmo CPF/CNPJ
        $data = [
            'nome' => $this->faker->name,
            'cpf_cnpj' => $usuario->cpf_cnpj,
            'cep' => $this->faker->numerify('#####-###'),
            'numero' => $this->faker->randomNumber(3),
            'telefone' => $this->faker->phoneNumber,
            'login' => $this->faker->userName,
            'senha' => bcrypt('password'),
            'interesses' => $this->faker->sentence,
        ];

        //Processar
        $response = $this->postJson('/api/usuarios/', $data);

        //Avaliar a saída
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['cpf_cnpj']);
    }

    /**
     * Deve buscar um ID no servidor com sucesso.
     *
     * @return void
     */
    public function test_buscar_id_no_banco_com_sucesso()
    {
        //Criar um usuário
        $usuario = Usuario::factory()->create();

        //Processar
        $response = $this->getJson('/api/usuarios/' . $usuario->id);

        //Verificar saída
        $response->assertStatus(200)
            ->assertJson([
                'id' => $usuario->id,
                'nome' => $usuario->nome,
                'cpf_cnpj' => $usuario->cpf_cnpj,
                'cep' => $usuario->cep,
                'numero' => $usuario->numero,
                'telefone' => $usuario->telefone,
                'login' => $usuario->login,
                'interesses' => $usuario->interesses,
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
        $response = $this->getJson('/api/usuarios/99999999');

        //Verificar saída
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Usuário não encontrado!",
            ]);
    }

    /**
     * Teste de atualização com sucesso.
     *
     * @return void
     */
    public function test_atualizar_usuario_com_sucesso()
    {
        //Criar um usuário
        $usuario = Usuario::factory()->create();

        //Criar novos dados
        $data = [
            'nome' => $this->faker->name,
            'cpf_cnpj' => $this->faker->numerify('##############'), // 13 números aleatórios
            'cep' => $this->faker->numerify('#####-###'), // CEP no formato 12345-678
            'numero' => (string) $this->faker->randomNumber(3), // Número aleatório de 3 dígitos
            'telefone' => $this->faker->phoneNumber,
            'login' => $this->faker->userName,
            'senha' => bcrypt('password'), // Substitua 'password' pela senha desejada
            'interesses' => $this->faker->sentence,
        ];

        //Processar
        $response = $this->putJson('/api/usuarios/' . $usuario->id, $data);

        //Verificar saída
        $response->assertStatus(200)
            ->assertJson([
                'id' => $usuario->id,
                'nome' => $data['nome'],
                'cpf_cnpj' => $data['cpf_cnpj'],
                'cep' => $data['cep'],
                'numero' => $data['numero'],
                'telefone' => $data['telefone'],
                'login' => $data['login'],
                'interesses' => $data['interesses'],
            ]);
    }

    /**
     * Teste de atualização com falha no ID.
     *
     * @return void
     */
    public function test_atualizar_usuario_com_falha_no_id()
    {
        //Criar novos dados
        $data = [
            'nome' => $this->faker->name,
            'cpf_cnpj' => $this->faker->numerify('##############'), // 13 números aleatórios
            'cep' => $this->faker->numerify('#####-###'), // CEP no formato 12345-678
            'numero' => (string) $this->faker->randomNumber(3), // Número aleatório de 3 dígitos
            'telefone' => $this->faker->phoneNumber,
            'login' => $this->faker->userName,
            'senha' => bcrypt('password'), // Substitua 'password' pela senha desejada
            'interesses' => $this->faker->sentence,
        ];

        //Processar
        $response = $this->putJson('/api/usuarios/999999999', $data);

        //Verificar saída
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Usuário não encontrado!",
            ]);
    }

    /**
     * Teste de atualização com falha de CPF/CNPJ duplicado.
     *
     * @return void
     */
    public function test_atualizar_usuario_com_falha_cpf_cnpj_duplicado()
    {
        //Criar dois usuários
        $usuario1 = Usuario::factory()->create();
        $usuario2 = Usuario::factory()->create();

        //Tentar atualizar o segundo com o CPF/CNPJ do primeiro
        $data = [
            'nome' => $this->faker->name,
            'cpf_cnpj' => $usuario1->cpf_cnpj,
            'cep' => $this->faker->numerify('#####-###'),
            'numero' => $this->faker->randomNumber(3),
            'telefone' => $this->faker->phoneNumber,
            'login' => $this->faker->userName,
            'senha' => bcrypt('password'),
            'interesses' => $this->faker->sentence,
        ];

        //Processar
        $response = $this->putJson('/api/usuarios/' . $usuario2->id, $data);

        //Verificar saída
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['cpf_cnpj']);
    }

    /**
     * Teste de atualização com falha nos dados.
     *
     * @return void
     */
    public function test_atualizar_usuario_com_falha_nos_dados()
    {
        //Criar um usuário
        $usuario = Usuario::factory()->create();

        //Criar novos dados inválidos
        $data = [
            'nome' => "",
            'cpf_cnpj' => "",
            'cep' => "",
            'numero' => "",
            'telefone' => "",
            'login' => "",
            'senha' => "", // Senha em branco
            'interesses' => "",
        ];

        //Processar
        $response = $this->putJson('/api/usuarios/' . $usuario->id, $data);

        //Verificar saída
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'nome', 'cpf_cnpj', 'cep', 'numero', 'telefone', 'login', 'senha', 'interesses',
            ]);
    }

    /**
     * Deletar com sucesso.
     *
     * @return void
     */
    public function test_deletar_com_sucesso()
    {
        //Criar um usuário
        $usuario = Usuario::factory()->create();

        //Processar
        $response = $this->deleteJson('/api/usuarios/' . $usuario->id);

        //Verificar saída
        $response->assertStatus(200)
            ->assertJson([
                'message' => "Usuário deletado com sucesso!",
            ]);
    }

    /**
     * Teste de remoção com falha no ID.
     *
     * @return void
     */
    public function test_remover_usuario_com_falha_no_id()
    {
        //Processar
        $response = $this->deleteJson('/api/usuarios/999999999');

        //Verificar saída
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Usuário não encontrado!",
            ]);
    }
}
