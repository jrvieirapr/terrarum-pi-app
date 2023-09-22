<?php

namespace Tests\Feature;

use App\Models\Evento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventoTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testListarEventos() {
    Evento::factory()->count(5)->create();
    $response = $this->getJson('/api/eventos');
  }
}
