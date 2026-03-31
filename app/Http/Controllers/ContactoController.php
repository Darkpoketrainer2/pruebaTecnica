<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index(Request $request)
    {
        $query = Contacto::query();

        // filtrado
        if ($request->has('buscar') && $request->buscar != '') {
            $busqueda = $request->buscar;
            $query->where('id', $busqueda)
                  ->orWhere('nombre', 'LIKE', '%' . $busqueda . '%')
                  ->orWhere('telefono', 'LIKE', '%' . $busqueda . '%');
        }

        return response()->json($query->get());
    }
    

    public function store(Request $request)
    {
        $request->validate([
    'nombre' => 'required|string|regex:/^[a-zA-Z\s]+$/',
    'telefono' => 'required|digits:10', // Exige que sean exactamente 10 números
    'fecha_nacimiento' => 'required|date|before_or_equal:today' // Exige que la fecha sea hoy o antes
], [
    // mensajes
    'nombre.regex' => 'El nombre solo acepta letras.',
    'telefono.digits' => 'El numero debe tener 10 dijitos.',
    'fecha_nacimiento.before_or_equal' => 'la fecha de nacimiento no puede ser futura'
]);
        return Contacto::create($request->all());
    }

    public function destroy($id)
    {
        return Contacto::destroy($id);
    }

    public function show($id)
{
    return response()->json(Contacto::find($id));
}

public function update(Request $request, $id)
{
    $request->validate([
    'nombre' => 'required|string|regex:/^[a-zA-Z\s]+$/',
    'telefono' => 'required|digits:10', // Exige que sean exactamente 10 números
    'fecha_nacimiento' => 'required|date|before_or_equal:today' // Exige que la fecha sea hoy o antes
], [
    // mensajes
    'nombre.regex' => 'El nombre solo acepta letras.',
    'telefono.digits' => 'El numero debe tener 10 dijitos.',
    'fecha_nacimiento.before_or_equal' => 'la fecha de nacimiento no puede ser futura'
]);

    $contacto = Contacto::findOrFail($id);
    $contacto->update($request->all());
    return response()->json($contacto);
}
}
