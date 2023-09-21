<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Http\Requests\StoreDestinoRequest;
use App\Http\Requests\UpdateDestinoRequest;

class DestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destino = Destino::all();
        //Retornar lista em formato json
        return response()->json(['data' => $destino]);
        //
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
    public function store(StoreDestinoRequest $request)
    {
        $destino = Destino::create($request->all());

        // // Retorne o tipo e o code 201
        return response()->json($destino, 201);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $destino = Destino::find($id);

        if (!$destino) {
            return response()->json(['message' => 'Destino não encontrado'], 404);
        }

        return response()->json($destino);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destino $destino)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDestinoRequest $request, Destino $destino)
    {
        
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destino $destino)
    {
        //
    }
}
