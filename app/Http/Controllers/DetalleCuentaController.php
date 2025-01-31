<?php

namespace App\Http\Controllers;

use App\Models\DetalleCuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetalleCuentaController extends Controller
{
    public function index(Request $request)
    {
        // Verifica si el parámetro cuenta_id está presente en la solicitud
        $cuentaId = $request->query('id_cuenta');
    
        if ($cuentaId) {
            // Filtra los detalles de la cuenta con el ID proporcionado
            
            $detalles = DetalleCuenta::with(['cuenta', 'prestacion','tipoPrestacion'])
                ->where('id_cuenta', $cuentaId) // Filtra por cuenta_id
                ->get();
    
            if ($detalles->isEmpty()) {
                return response()->json(['message' => 'No hay detalles de cuenta registrados para esta cuenta', 'status' => 200], 200);
            }
    
            return response()->json($detalles, 200);
        }
    
        // Si no se pasa  devuelve todos los detalles
        $detalles = DetalleCuenta::with(['cuenta', 'prestacion','tipoPrestacion'])->get();
    
        if ($detalles->isEmpty()) {
            return response()->json(['message' => 'No hay detalles de cuenta registrados', 'status' => 200], 200);
        }
    
        return response()->json($detalles, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_cuenta' => 'required|exists:cuentas,id',
            'cantidad_producto' => 'required|integer|min:1',
            'valor_producto' => 'required|integer|min:1',
            'estado' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos incorrectos',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $detalle = DetalleCuenta::create($request->all());

        return response()->json([
            'message' => 'Detalle de cuenta creado correctamente',
            'data' => $detalle,
            'status' => 201,
        ], 201);
    }

    public function show($id)
    {
        $detalle = DetalleCuenta::with(['cuenta', 'prestacion'])->find($id);

        if (!$detalle) {
            return response()->json(['message' => 'Detalle de cuenta no encontrado', 'status' => 404], 404);
        }

        return response()->json($detalle, 200);
    }

    public function update(Request $request, $id)
    {
        $detalle = DetalleCuenta::find($id);

        if (!$detalle) {
            return response()->json(['message' => 'Detalle de cuenta no encontrado', 'status' => 404], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_cuenta' => 'exists:cuentas,id',
            'cantidad_producto' => 'integer|min:1',
            'valor_producto' => 'integer|min:1',
            'estado' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos incorrectos',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $detalle->update($request->all());

        return response()->json([
            'message' => 'Detalle de cuenta actualizado correctamente',
            'data' => $detalle,
            'status' => 200,
        ], 200);
    }

    public function destroy($id)
    {
        $detalle = DetalleCuenta::find($id);

        if (!$detalle) {
            return response()->json(['message' => 'Detalle de cuenta no encontrado', 'status' => 404], 404);
        }

        $detalle->delete();

        return response()->json(['message' => 'Detalle de cuenta eliminado correctamente', 'status' => 200], 200);
    }
}
