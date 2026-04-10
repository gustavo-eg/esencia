<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recepcionista;

class RecepcionistaController extends Controller
{
    /**
     * limita al acceso de la clase con autenticacion
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $recepcionistas = Recepcionista::all();  //se puede filtrar
        //retornar la vista 
        return view('recepcionista.index')->with('recepcionistas',$recepcionistas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //retornar la vista
        return view('recepcionista.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validacion de los campos
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required'
        ]);
        //guardado de los datos del formulario de alta
        $recepcionista = new Recepcionista();
        $recepcionista->nombre = ucwords(mb_strtolower($request->get('nombre')));
        $recepcionista->apellido = ucwords(mb_strtolower($request->get('apellido')));
        $recepcionista->save();

        //puedo obtener el id
        $nuevo_id = $recepcionista->id;
        
        //una vez guardado, se manda a la pagina del listado
        return redirect('/recepcionista');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 
        $recepcionista = Recepcionista::find($id);  //se puede filtrar
        return view('recepcionista.edit')->with('recepcionista',$recepcionista);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //boton guardar del formulario editar
        //validacion de los campos
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required'
        ]);
          $recepcionista = Recepcionista::find($id);
          $recepcionista->nombre = ucwords(mb_strtolower($request->get('nombre')));
          $recepcionista->apellido = ucwords(mb_strtolower($request->get('apellido')));
            $recepcionista->save();
          
          //una vez guardado, se manda a la pagina del listado
          return redirect('/recepcionista');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //cuando presiona borrar
        $recepcionista = Recepcionista::find($id);
        $recepcionista->delete();
        return back()->with('success','Eliminada satisfactoriamente');
    }
}
