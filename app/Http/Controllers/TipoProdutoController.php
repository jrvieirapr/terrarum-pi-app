<?php

namespace App\Http\Controllers;

use App\Models\TipoProduto;
use App\Http\Requests\StoreTipoProdutoRequest;
use App\Http\Requests\UpdateTipoProdutoRequest;

class TipoProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos_produtos = TipoProduto::all();
         $tipos_produtos = TipoProduto::Paginate(50);
        $total = TipoProduto::all()->count();
        return view("tipos_produtos.index", compact(["tipos_produtos", "total"]));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoProdutoRequest $request)
    {
        //$data = $request->all();
        $tipos = TipoProduto::create($data);
        return redirect()->route('tiposprodutos.index');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoProduto $tipoProduto)
    {
        return view("tipos_produtos.show", compact(["tipoProduto"]));
    
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoBichoRequest $request, TipoBicho $tiposbicho)
    {
        $data = $request->all();
        $tiposbicho->update($data);
        return redirect()->route('tiposbichos.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoProduto $tipoProduto)
    {
        //
        if (isset($tiposproduto)) {
            $tiposproduto->delete();
            //
        }
        return redirect()->route('tiposprodutos.index');
    }



    

