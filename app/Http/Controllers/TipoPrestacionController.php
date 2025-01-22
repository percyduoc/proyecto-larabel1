<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoPrestacion;
use Illuminate\Http\Request;

class TipoPrestacionController extends Controller
{
    public function index()
    {
        try {
            $tiposPrestaciones = TipoPrestacion::all();
            return response()->json($tiposPrestaciones, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'estado' => 'required|boolean',
            'descripcion' => 'nullable|string',
        ]);

        $tipoPrestacion = TipoPrestacion::create($request->all());
        return response()->json($tipoPrestacion, 201);
    }

    public function show($id)
    {
        $tipoPrestacion = TipoPrestacion::findOrFail($id);
        return response()->json($tipoPrestacion);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'estado' => 'required|boolean',
            'descripcion' => 'nullable|string',
        ]);

        $tipoPrestacion = TipoPrestacion::findOrFail($id);
        $tipoPrestacion->update($request->all());
        return response()->json($tipoPrestacion);
    }

    public function destroy($id)
    {
        $tipoPrestacion = TipoPrestacion::findOrFail($id);
        $tipoPrestacion->delete();
        return response()->noContent();
    }
}
