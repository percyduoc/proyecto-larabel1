<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuentaController extends Controller
{
    public function index()
    {
           
        return Cuenta::with(['sucursal', 'tipoVenta',])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'direccion' => 'required|max:255',
            'sucursal_id' => 'required|exists:sucursals,id',
            'tipo_venta_id' => 'required|exists:tipo_ventas,id',
            'estado' => 'required|boolean',
        ]);

        $cuenta = Cuenta::create($request->all());
        return response()->json($cuenta, 201);
    }
    

    public function show($id)
    {
        $cuenta = Cuenta::with(['sucursal', 'tipoVenta'])->findOrFail($id);
        return response()->json($cuenta);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'direccion' => 'required|max:255',
            'sucursal_id' => 'required|exists:sucursals,id',
            'tipo_venta_id' => 'required|exists:tipo_ventas,id',
            'estado' => 'required|boolean',
        ]);

        $cuenta = Cuenta::findOrFail($id);
        $cuenta->update($request->all());
        return response()->json($cuenta);
    }

    public function destroy($id)
    {
        $cuenta = Cuenta::findOrFail($id);

        // Verificar si la cuenta está activa
        if ($cuenta->estado) {
            return response()->json([
                'message' => 'No se puede eliminar la cuenta porque está activa.',
            ], 400);
        }

        // Proceder a eliminar la cuenta
        $cuenta->delete();

        return response()->json(['message' => 'Cuenta eliminada correctamente.'], 200);
    }
    public function getTotalCuenta($id)
    {
        $totalCuenta = DB::table('cuentas as c')
            ->select(
                'c.id as id_cuenta',
                'c.nombre as nombre_cuenta',
                DB::raw('SUM(dc.valor_producto * dc.cantidad_producto) as total_cuenta')
            )
            ->join('detalle_cuentas as dc', 'c.id', '=', 'dc.id_cuenta')
            ->where('c.id', $id)
            ->groupBy('c.id', 'c.nombre')
            ->first();

        if (!$totalCuenta) {
            return response()->json(['message' => 'Cuenta no encontrada o sin detalles.'], 404);
        }

        return response()->json($totalCuenta);
    }


}
