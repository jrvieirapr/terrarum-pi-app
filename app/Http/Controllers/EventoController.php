<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //pegar a lista do banco
        $eventos = Evento::all();

        //retornar lista em formato json
        return response()->json(['data' => $eventos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoRequest $request)
    {
        // crie um novo evento
        $evento = Evento::create($request->all());
        //retorne o evento e o 201
        return response()->json($evento, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //procure evento por id
        $evento = Evento::find($id);
        if (!$evento) {
            return response()->json(['message' => 'Evento não encontrado'], 404);
        }
        return response()->json($evento);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoRequest $request, $id)
    {
        // Procure o tipo pela id
        $evento = Evento::find($id);
        if (!$evento) {
            return response()->json(['message' => 'Evento não encontrado'], 404);
        }
        //faça o update do evento
        $evento->update($request->all());
        //retorne o evento
        return response()->json($evento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //encontre um  evento pelo ID
        $evento = Evento::find($id);
        if (!$evento) {
            return response()->json(['message' => 'Evento não encontrado!'], 404);
        }
        //se tiver filho retornar erro
        // delete o brand
        $evento->delete();
        return response()->json(['message' => 'Evento deletado com sucesso!'], 200);
    }
}
