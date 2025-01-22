<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoVenta;
use Illuminate\Http\Request;

class TipoVentaController extends Controller
{
    public function index()
    {
        $tipoVenta = TipoVenta::all();
        if ($tipoVenta->isEmpty()) {
            return response()->json(['message' => 'No hay tipos de venta registrados'], 201);
        }
        else
        {
            return response()->json( $tipoVenta, 201);
        }
 

    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

        $tipoVenta = TipoVenta::create($request->all());
        return response()->json($tipoVenta, 201);
    }

    public function show($id)
    {
        $tipoVenta = TipoVenta::findOrFail($id);
        return response()->json($tipoVenta);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

        $tipoVenta = TipoVenta::findOrFail($id);
        $tipoVenta->update($request->all());
        return response()->json($tipoVenta);
    }

    public function destroy($id)
    {
        $tipoVenta = TipoVenta::find($id);
        if ($tipoVenta) {
            $tipoVenta->delete();
            return response()->json(['message' => 'Sucursal eliminada'], 200);
        }

        return response()->json(['message' => 'Sucursal no encontrada'], 404);
    }
}
