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
            "nome" => $this->faker->word,
            "coordenadas" => "15.23,25.45"
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
            "nome" => '',
            "coordenadas" => ' '
        ];
         // Fazer uma requisição POST
        $response = $this->postJson('/api/destinos', $data);

        // Verifique se teve um retorno 422 - Falha no salvamento
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(422)// se quero falha é essa resposta qie eu quero
            ->assertJsonValidationErrors(['nome','coordenadas']); // validacao nesse campo
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

    /**
     * Teste de pesquisa de registro com falha
     *
     * @return void
     */
    public function testPesquisaDestinoComFalha()
    {
        // Fazer pesquisa com um id inexistente
        $response = $this->getJson('/api/destinos/999'); // o 999 nao pode existir

        // Veriicar a resposta
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Destino não encontrado'
            ]);
    }

    /**
     *Teste de upgrade com sucesso
     *
     * @return void
     */
    public function testUpdateDestinoSucesso()
    {
        // Crie um tipo fake
        $destino = Destino::factory()->create();

        // Dados para update
        $newData = [
            'nome' => 'castro',     

            'coordenadas' => '15.25,35.85',            
        ];

          
        // Faça uma chamada PUT
        $response = $this->putJson('/api/destinos/' . $destino->id, $newData);

        // Verifique a resposta
        $response->assertStatus(200)
            ->assertJson([
                'id' => $destino->id,
                'nome' => $newData['nome'],            
                'coordenadas' => $newData['coordenadas'],
            ]);
    }

    /**
     * Testando com falhas
     *
     * @return void
     */
    public function testUpdateDestinoDataInvalida()
    {
        // Crie um tipo falso
        $destino = Destino::factory()->create();

        // Crie dados falhos
        $invalidData = [ //data=dados (lembrando que para criar uma variavel usa o $ na frente)
            'nome' => '', // Invalido: Descricao vazio
            'coordenadas' => '', // Invalido: Descricao vazio
        ];

        // faça uma chamada PUT
        $response = $this->putJson('/api/destinos/' . $destino->id, $invalidData);

        // Verificar se teve um erro 422
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome', 'coordenadas']);// erro nessa informação
    }
    
    /**
     * Teste update de marca
     *
     * @return void
     */
    public function testUpdateDestinoNaoExistente()
    {
        // Faça uma chamada para um id falho
        $response = $this->putJson('/api/destinos/999', ['nome' => 'Destino Nome', 'coordenadas' => 'Destino Coordenadas' ]); //O 999 não deve existir

        // Verificar o retorno 404
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Destino não encontrado'
            ]);
    }
    
     /**
     * Teste de upgrade com os mesmos dados
     *
     * @return void
     */
    public function testUpdateDestinoMesmosDados()
    {

        // Criar um tipo usando o factory
        $destino = Destino::factory()->create();

        //Criar o objeto
        $data = [
            'nome' => "" . $this->faker->word . " " .
                $this->faker->numberBetween($int1 = 0, $int2 = 99999),
            'coordenadas' => "" . $this->faker->sentence(),            
        ];

         // Fazer uma requisição POST
         $response = $this->postJson('/api/destinos', $data);

         //dd($response);
 
         // Verifique se teve um retorno 201 - Criado com Sucesso
         // e se a estrutura do JSON Corresponde
         $response->assertStatus(201)
             ->assertJsonStructure(['nome', 'coordenadas', 'created_at', 'updated_at']);
  
}

/**
     * Teste upgrade com nome duplicado
     *
     * @return void
     */
    public function testUpdateDestinoDescricaoDuplicada()
    {
        // Crie dois tipos fakes
        $destinoExistente = Destino::factory()->create();
        $destinoUpgrade = Destino::factory()->create();

        // Para para upgrade
        $newData = [
            'nome' => $destinoExistente->destino,            
            'coordenadas' => $destinoExistente->destino,            
        ];

        // Faça o put 
        $response = $this->putJson('/api/destinos/' . $destinoUpgrade->id, $newData);

        // Verifique a resposta
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome', 'coordenadas']);
    }

 /**
     * Teste de deletar com sucesso
     *
     * @return void
     */
    public function testDeleteDestino()
    {
        // Criar tipo fake
        $destino = Destino::factory()->create();

        // enviar requisição para Delete
        $response = $this->deleteJson('/api/destinos/' . $destino->id);

        // Verifica o Detele
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Destino deletado com sucesso!'
            ]);

        //Verifique se foi deletado do banco
        $this->assertDatabaseMissing('destinos', ['id' => $destino->id]);
    }

    /**
     * Teste remoção de registro inexistente
     *
     * @return void
     */
    public function testDeleteDestinoNaoExistente()
    {
        // enviar requisição para Delete
        $response = $this->deleteJson('/api/destinos/999');

        // Verifique a resposta
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Destino não encontrado!'
            ]);
    }

}