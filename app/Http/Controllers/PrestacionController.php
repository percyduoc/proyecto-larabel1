<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prestacion;
use Illuminate\Http\Request;

class PrestacionController extends Controller
{
    public function index()
    {
        return Prestacion::with('tipoPrestacion')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:prestaciones,codigo|max:255',
            'nombre' => 'required|max:255',
            'tipo_prestacion_id' => 'required|exists:tipo_prestaciones,id',
            'valor' => 'required|integer',
            'estado' => 'required|boolean',
        ]);

        $prestacion = Prestacion::create($request->all());
        return response()->json($prestacion, 201);
    }

    public function show($codigo)
    {
        $prestacion = Prestacion::with('tipoPrestacion')->findOrFail($codigo);
        return response()->json($prestacion);
    }

    public function update(Request $request, $codigo)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'tipo_prestacion_id' => 'required|exists:tipo_prestaciones,id',
            'valor' => 'required|integer',
            'estado' => 'required|boolean',
        ]);

        $prestacion = Prestacion::findOrFail($codigo);
        $prestacion->update($request->all());
        return response()->json($prestacion);
    }

    public function destroy($codigo)
    {
        $prestacion = Prestacion::findOrFail($codigo);
        $prestacion->delete();
        return response()->noContent();
    }
}
