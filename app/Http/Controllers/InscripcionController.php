<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Pago;
use App\Models\Recepcionista;

class InscripcionController extends Controller
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
        $inscripciones = Inscripcion::all();  //se puede filtrar
        //retornar la vista 
        return view('inscripcion.index')->with('inscripciones',$inscripciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //retornar la vista
        $recepcionistas = Recepcionista::all();
        return view('inscripcion.create')->with('recepcionistas',$recepcionistas);
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
            'n_apellido' => 'required | unique:inscripcions',
            'nro_entrada' => 'nullable | numeric | digits_between:0,500',
            'celular' => 'nullable | numeric | gt:0',
            'fecha' => 'required | date',
            'inscribio' => 'required',
            'financiacion' => 'required',
            'valorTotal' => 'required | numeric | digits_between:1,6'
        ]);
        //guardado de los datos del formulario de alta
        $inscripcion = new Inscripcion();
        //$inscripcion->nro_entrada = $request->get('nro_entrada');
        $inscripcion->fecha = $request->get('fecha');
        $inscripcion->n_apellido = ucwords(mb_strtolower($request->get('n_apellido')));
        $inscripcion->celular = $request->get('celular');
        $inscripcion->membresia = $request->get('membresia');
        $inscripcion->inscribio = ucwords(mb_strtolower($request->get('inscribio')));
        $inscripcion->tipo = $request->get('tipo');
        $inscripcion->observacion = $request->get('observacion');

        $inscripcion->valorTotal = $request->get('valorTotal'); // se usa para saber el importe total que tiene que pagar
        if($request->get('financiacion') == "cuotas"){
            $inscripcion->financiacion = 1; //true
            $inscripcion->completado = 0; //no está completado cuando inicia con cuotas
        }else{
            $inscripcion->completado = 1; //paga inicial completo
            $inscripcion->financiacion = 0; //no hay financiacion
        }

        $inscripcion->save();

        //puedo obtener el id
        $nuevo_id = $inscripcion->id;
        $pago = new Pago();
        $importe = $request->get('importe');
       
        $pago->importe = $importe;
        $pago->modo = $request->get('formapago');
        $pago->observacion = $request->get('observacion');
        $pago->recibio = ucwords(mb_strtolower($request->get('inscribio')));
        $pago->fecha = $request->get('fecha');
        $pago->inscripcion_id = $nuevo_id;
        $pago->save();
        
        //una vez guardado, se manda a la pagina del listado
        return redirect('/inscripcion');
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
        $inscripcion = Inscripcion::find($id);  //se puede filtrar
        return view('inscripcion.edit')->with('inscripcion',$inscripcion);
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
            'n_apellido' => 'required',
            'nro_entrada' => 'nullable | numeric | digits_between:0,500',
            'celular' => 'nullable | numeric | gt:0',
            'fecha' => 'required | date',
            'inscribio' => 'required'
        ]);
          $inscripcion = Inscripcion::find($id);
          $inscripcion->nro_entrada = $request->get('nro_entrada');
          $inscripcion->fecha = $request->get('fecha');
          $inscripcion->n_apellido = ucwords(mb_strtolower($request->get('n_apellido')));
          $inscripcion->celular = $request->get('celular');
          $inscripcion->membresia = $request->get('membresia');
          $inscripcion->lider = ucwords(mb_strtolower($request->get('lider')));
          $inscripcion->inscribio = ucwords(mb_strtolower($request->get('inscribio')));
  
          $inscripcion->save();
          
          //una vez guardado, se manda a la pagina del listado
          return redirect('/inscripcion');
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
        $inscripcion = Inscripcion::find($id);
        $inscripcion->delete();
        return back()->with('success','Eliminada satisfactoriamente');
    }
}