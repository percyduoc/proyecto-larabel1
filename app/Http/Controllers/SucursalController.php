<?php
namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::all();
        if ($sucursales->isEmpty()) {
            return response()->json(['message' => 'No hay sucursales registradas'], 200);
        }
        return response()->json($sucursales, 200);
        
    }

    public function show($id)
    {
        $sucursal = Sucursal::find($id);
        if ($sucursal) {
            return response()->json($sucursal);
        }
        return response()->json(['message' => 'Sucursal no encontrada'], 404);
    }

    public function store(Request $request)
    {
        // Validación de los datos
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'region' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'estado' => 'boolean',
    ]);

    // Creación de la sucursal
    try {
        $sucursal = Sucursal::create($validated);
        return response()->json($sucursal, 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al crear la sucursal', 'message' => $e->getMessage()], 500);
    }
    }

    public function update(Request $request, $id)
    {
        $sucursal = Sucursal::find($id);
        if (!$sucursal) {
            return response()->json(['message' => 'Sucursal no encontrada'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'string|max:255',
            'region' => 'string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'boolean'
        ]);

        $sucursal->update($validated);
        return response()->json($sucursal);
    }

    public function destroy($id)
    {
        $sucursal = Sucursal::find($id);
        if ($sucursal) {
            $sucursal->delete();
            return response()->json(['message' => 'Sucursal eliminada'], 200);
        }

        return response()->json(['message' => 'Sucursal no encontrada'], 404);
    }
}
