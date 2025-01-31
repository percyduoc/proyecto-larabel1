<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Precio;
use Illuminate\Http\Request;

class PrecioController extends Controller
{
    public function index()
    {
        return Precio::with(['prestaciones',])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prestaciones' => 'required|exists:prestaciones,codigo',
            'valor' => 'required|integer|min : 0',
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'nullable|date|after_or_equal:fecha_desde',
            'estado' => 'required|boolean',
        ]);

        $precio = Precio::create($request->all());
        return response()->json($precio, 201);
    }

    public function show($id)
    {
        $precio = Precio::with(['prestaciones',])->findOrFail($id);
        return response()->json($precio);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_prestaciones' => 'required|exists:prestaciones,codigo',
            'valor' => 'required|integer',
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'nullable|date|after_or_equal:fecha_desde',
            'estado' => 'required|boolean',
        ]);

        $precio = Precio::findOrFail($id);
        $precio->update($request->all());
        return response()->json($precio);
    }

    public function destroy($id)
    {
        $precio = Precio::findOrFail($id);
        $precio->delete();
        return response()->noContent();
    }
}
