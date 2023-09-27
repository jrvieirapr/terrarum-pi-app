<?php

namespace Tests\Feature;

use App\Models\Destino;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestinoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testListarTodosDestinos()
    {
        Destino::factory()->count(5)->create();

        // usar metodo GET para verificar o retorno
        $response = $this->getJson('/api/destinos');

        //Testar ou verificar saida
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['nome','coordenadas', 'created_at', 'updated_at']

                ]
            ]);
    }   

   /**
     * Criar um destino
     */
    public function testCriarDestinoSucesso(){

        //Criar o objeto
        $data = [
            "nome" => $this->faker->word
        ];

        //Debug
        //dd($data);

        // Fazer uma requisição POST -  para salvar
        $response = $this->postJson('/api/destinos', $data);

        //dd($response);

        // Verifique se teve um retorno 201 - Criado com Sucesso
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(201)// preciso desse retorno
            ->assertJsonStructure(['id', 'nome','coordenadas', 'created_at', 'updated_at']);// com essas informações

    }

    
    /**
     * Teste de criação com falhas
     *
     * @return void
     */
    public function testCriacaoDestinoFalha()
    {
        $data = [
            "nome" => 'a'
        ];
         // Fazer uma requisição POST
        $response = $this->postJson('/api/destinos', $data);

        // Verifique se teve um retorno 422 - Falha no salvamento
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(422)// se quero falha é essa resposta qie eu quero
            ->assertJsonValidationErrors(['nome']); // validacao nesse campo
    }

     /**
     * Teste de pesquisa de registro
     *
     * @return void
     */
    public function testPesquisadestinoSucesso()
    {
        // Criar um tipo
        $destino = Destino::factory()->create();

        
        // Fazer pesquisa
        $response = $this->getJson('/api/destinos/' . $destino->id);   
        
        // Verificar saida //no show(controller)
        $response->assertStatus(200)
            ->assertJson([
                'id' => $destino->id,
                'nome' => $destino->nome,
                'coordenadas' => $destino->coordenadas,                
            ]);
    }
   
}

