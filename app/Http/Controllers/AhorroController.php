<?php

namespace App\Http\Controllers;

use App\Models\Ahorro;
use Illuminate\Http\Request;

class AhorroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Ahorro::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //Esta validacion hace que si o si se valide que se envie estos datos
        $request ->validate([
            'nombre' => 'required',
            'porcentaje' => 'required',
            'ahorro' => 'boolean',
            'gasto' => 'boolean',
        ]);
        //para mandar post de datos de un cliente

        $ahorro = new Ahorro;
        $ahorro->nombre  = $request->nombre;
        $ahorro->porcentaje = $request->porcentaje;
        $ahorro->ahorro = $request->ahorro;
        $ahorro->gasto = $request->gasto;
        $ahorro->descripcion = $request->descripcion;
        $ahorro->resultadoAcumulado = $request->resultadoAcumulado;

        $ahorro->save();

        return $ahorro;
    }

    /**
     * Display the specified resource.
     */
    public function show(Ahorro $ahorro)
    {
        //
        return $ahorro;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ahorro $ahorro)
    {
        //
        $request ->validate([

        ]);

        $ahorro ->nombre = $request->nombre;
        $ahorro->porcentaje = $request->porcentaje;
        $ahorro->porcentaje = $request->porcentaje;
        $ahorro->ahorro = $request->ahorro;
        $ahorro->gasto = $request->gasto;
        $ahorro->descripcion = $request->descripcion;
        $ahorro->resultadoAcumulado = $request->resultadoAcumulado;
        $ahorro->update();

        return $ahorro;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ahorro $ahorro)
    {
        //
        $ahorro->delete();
        return response()->noContent();
    }

    public function actualizarResultadoAcumulado(Request $request)
{
    $request->validate([
        'actualizaciones.*.id' => 'required|exists:ahorros,id',
        'actualizaciones.*.resultadoAcumulado' => 'required|numeric',
    ]);

    $actualizaciones = $request->input('actualizaciones');

    foreach ($actualizaciones as $actualizacion) {
        $ahorro = Ahorro::find($actualizacion['id']);
        $ahorro->resultadoAcumulado = $actualizacion['resultadoAcumulado'];
        $ahorro->save();
    }

    return response()->json(['message' => 'Campos resultadoAcumulado actualizados correctamente']);
}


public function actualizarResultadoAcumuladoUno(Request $request, $id)
{
    $request->validate([
        'resultadoAcumulado' => 'required|numeric',
    ]);

    $ahorro = Ahorro::find($id);

    if (!$ahorro) {
        return response()->json(['message' => 'No se encontró el ahorro con el ID proporcionado'], 404);
    }

    $ahorro->resultadoAcumulado = $request->input('resultadoAcumulado');
    $ahorro->save();

    return response()->json(['message' => 'Campo resultadoAcumulado actualizado correctamente']);
}


}
