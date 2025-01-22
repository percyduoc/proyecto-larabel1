<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();

        if ($productos->isEmpty()) {
            $data=[
                'message' => 'No hay productos registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        return response()->json($productos, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator :: make($request->all(), [
            'codigo' => 'required|string|max:50|unique:productos',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'valor' => 'required|integer',
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'nullable|date',
            'estado' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            $data=[
                'message' => 'Datos incorrectos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $producto = Producto::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'valor' => $request->valor,
            'fecha_desde' => $request->fecha_desde,
            'fecha_hasta' => $request->fecha_hasta,
            'estado' => $request->estado
        ]);
        if ($producto) {
            $data=[
                'message' => 'Producto creado correctamente',
                'status' => 201
            ];
            return response()->json($data, 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data=[
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($producto, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        
        if (!$producto) {
            $data=[
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $validator = Validator :: make($request->all(), [
            'codigo' => 'required|string|max:50|',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'valor' => 'required|integer',
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'nullable|date',
            'estado' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            $data=[
                'message' => 'Datos incorrectos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->valor = $request->valor;
        $producto->fecha_desde = $request->fecha_desde;
        $producto->fecha_hasta = $request->fecha_hasta;
        $producto->estado = $request->estado;
        $producto->save();

        $data=[
            'message' => 'Producto actualizado correctamente',
            'producto' => $producto,
            'status' => 200
        ];
    }
    public function updatePartial(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data=[
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($data, 200);

       $validator = Validator :: make($request->all(), [
            'codigo' => 'string|max:50|unique:productos',
            'nombre' => 'string|max:100',
            'descripcion' => 'string',
            'valor' => 'integer',
            'fecha_desde' => 'date',
            'fecha_hasta' => 'date',
            'estado' => 'boolean'
        ]);
        if ($validator->fails()) {
            $data=[
                'message' => 'Datos incorrectos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        if ($request->codigo) {
            $producto->codigo = $request->codigo;
        }
        if ($request->nombre) {
            $producto->nombre = $request->nombre;
        }
        if ($request->descripcion) {
            $producto->descripcion = $request->descripcion;
        }
        if ($request->valor) {
            $producto->valor = $request->valor;
        }
        if ($request->fecha_desde) {
            $producto->fecha_desde = $request->fecha_desde;
        }
        if ($request->fecha_hasta) {
            $producto->fecha_hasta = $request->fecha_hasta;
        }
        if ($request->estado) {
            $producto->estado = $request->estado;
        }
        $producto->save();
        $data=[
            'message' => 'Producto actualizado correctamente',
            'producto' => $producto,
            'status' => 200
        ];
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data=[
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $producto->delete();

        $data=[
            'message' => 'Producto eliminado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
