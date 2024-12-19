<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bordado;

class BordadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bordados = Bordado::where('nome', 'like', '%' . $search . '%')
            ->paginate(10);

        return view('bordados.index', compact('bordados', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bordados.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'local' => 'required|string|max:255',
        ]);


        \App\Models\Bordado::create([
            'nome' => $request->nome,
            'preco' => $request->preco,
            'local' => $request->local,
        ]);

        return redirect()->route('bordados.index')->with('success', 'Bordado criado com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bordado = Bordado::findOrFail($id);
        return view('bordados.show', compact('bordado'));
    }


    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bordado = Bordado::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'local' => 'required|string|max:255',
        ]);

        $bordado->update($request->only('nome', 'preco', 'local'));

        return redirect()->route('bordados.index')->with('success', 'Bordado atualizado com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bordado = Bordado::findOrFail($id);
        $bordado->delete();

        return redirect()->route('bordados.index')->with('success', 'Bordado excluído com sucesso!');
    }

}
