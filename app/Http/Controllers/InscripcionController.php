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
            'financiacion' => [
                'nullable',
                function($attribute, $value, $fail) use ($request){
                    if($value == 'cuotas'){
                        if($request->get('valorTotal') == 0){
                            $fail('No se permite cuotas cuando no se paga.');
                        }
                    }
                }
            ],
            'valorTotal' => [
                'nullable',
                'numeric',
                'digits_between:1,6',
                function($attribute, $value, $fail) use ($request){
                    if($request->get('financiacion') == 'cuotas'){
                        if($value == $request->get('importe')){
                            //está indicando cuota, cuando está pagando el valor total. Inconsistencia.
                            $fail('Se trata de un pago completo.'); 
                        }
                    }
                }
                ],
            'importe' => [
                'numeric',
                function ($attribute, $value, $fail) use ($request){
                    if($request->get('financiacion') == 'completo'){
                        if($value != $request->get('valorTotal')){
                            $fail('El pago completo debe coincidir con el valor total.');
                        }
                    }
                }
            ]

        ]);

        //validacion de condiciones antes de guardar
        //1-cuando el pago es completo, el importe tiene que coincidir con el valor total
        //2-cuando el importe coincide con el valor total, debería ser completo
        //3-si es pastora, tiene costo cero
        //4-si es tipo especial, puede tener cualquier valor incluso cero.
       
        //guardado de los datos del formulario de alta
        $inscripcion = new Inscripcion();
        //$inscripcion->nro_entrada = $request->get('nro_entrada');
        $inscripcion->fecha = $request->get('fecha');
        $inscripcion->n_apellido = ucwords(mb_strtolower($request->get('n_apellido')));
        $inscripcion->celular = $request->get('celular');
        $inscripcion->membresia = $request->get('membresia');
        $inscripcion->id_recepcionista = $request->get('inscribio');
        $inscripcion->tipo = $request->get('tipo');
        if($inscripcion->tipo == "pastora"){
            $inscripcion->valorTotal = 0;
           
        }else{
            $inscripcion->valorTotal = $request->get('valorTotal'); // se usa para saber el importe total que tiene que pagar
        }
        $inscripcion->observacion = $request->get('observacion');

        
        if($request->get('financiacion') == "cuotas"){
            $inscripcion->financiacion = 1; //true
            $inscripcion->completado = 0; //no está completado cuando inicia con cuotas
            $importe = $request->get('importe');
        }else{
            $inscripcion->completado = 1; //paga inicial completo
            $inscripcion->financiacion = 0; //no hay financiacion
            $importe = $inscripcion->valorTotal;
        }

        $inscripcion->save();

        //puedo obtener el id
        $nuevo_id = $inscripcion->id;
        $pago = new Pago();
       if($inscripcion->valorTotal == 0){
            $pago->importe = 0;

       }else{
            $pago->importe = $importe;
       }
        //$pago->importe = $importe;
        if($pago->importe == 0){
            $pago->modo = "efectivo";
        }else{
            $pago->modo = $request->get('formapago');
        }
        $pago->observacion = $request->get('observacion');
        $pago->id_recepcionista = $request->get('inscribio');
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
        $recepcionistas = Recepcionista::all();
        return view('inscripcion.edit')->with(['inscripcion' => $inscripcion, 'recepcionistas' => $recepcionistas]);
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
            'celular' => 'nullable | numeric | gt:0',
            'fecha' => 'required | date',
            'inscribio' => 'required'
        ]);
          $inscripcion = Inscripcion::find($id);
          $inscripcion->fecha = $request->get('fecha');
          $inscripcion->n_apellido = ucwords(mb_strtolower($request->get('n_apellido')));
          $inscripcion->celular = $request->get('celular');
          $inscripcion->membresia = $request->get('membresia');
          $inscripcion->id_recepcionista = $request->get('inscribio');
  
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