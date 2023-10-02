<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = Usuario::all();
        //Retornar lista em formato json
        return response()->json(['data' => $usuario]);
        //
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsuarioRequest $request)
    {
        $usuario = Usuario::create($request->all());

        // // Retorne o Usuario e o code 201
        return response()->json($usuario, 201);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }

        return response()->json($usuario);
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsuarioRequest $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }

        // Faça o update do tipo
        $usuario->update($request->all());

        // Retorne o tipo
        return response()->json($usuario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }
        //sempre verificar se existe e se há classes dependentes, se sim, retornar erro.

        // Delete the brand
        $usuario->delete();

        return response()->json(['message' => 'Usuário deletado com sucesso!'], 200);
    }
}
