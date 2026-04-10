<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Pago;

class PagoController extends Controller
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
        //muestra un resumen de todos los pagos hasta el momento
        $pagos = Pago::all()
               ->sum('importe');
        $inscriptas_total = Inscripcion::all()
                ->count();
        $incriptas_completadas = Inscripcion::where('completado', 1)
                ->count();
        $fecha_hoy =  date("d/m/Y");

        //return view('pago.index')->with('inscripcion',$inscripcion);
        return view('pago.resumen', ['pago_total' => $pagos, 'fecha_hoy' => $fecha_hoy, 'pagos_completados' => $incriptas_completadas, 'inscriptas_total' => $inscriptas_total]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //retornar la vista para crear un nuevo pago (cuota)
        $inscripcion = Inscripcion::find($id);  //se puede filtrar

        return view('pago.create', ['inscripcion' => $inscripcion]);
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
            'fecha' => 'required | date',
            'recibio' => 'required',
            'importe' => 'required_if:promo,cuotas | digits_between:1,2000'
        ]);
        //guardado de los datos del formulario de nueva cuota
        $pago = new Pago();
        $pago->fecha = $request->get('fecha');
        $pago->importe = $request->get('importe');
        $pago->recibio = ucwords(mb_strtolower($request->get('recibio')));
        $pago->modo = $request->get('formapago');
        $pago->observacion = $request->get('observacion');
        $pago->inscripcion_id = $request->get('inscripcion_id');
        $pago->save();

        //actualizacion del estado del pago general
        $total = Pago::where('inscripcion_id',$pago->inscripcion_id)->sum('importe');
        $inscripcion = Inscripcion::find($pago->inscripcion_id);
        if(($total >= 80000 && $inscripcion->promo != "almuerzo") || ($total >= 80000 && $inscripcion->promo == "almuerzo")){
            $inscripcion->completado = 1;
        }else{
            $inscripcion->completado = 0;
        }
        $inscripcion->save();
        
        //una vez guardado, se manda a la pagina del listado
        return redirect('/pago/'.$request->get('inscripcion_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //vista de los pagos y datos de una inscripta
        $pagos = Pago::where('inscripcion_id', $id)
                ->orderBy('fecha', 'asc')
                ->get();  //se puede filtrar
        $total = Pago::where('inscripcion_id',$id)->sum('importe');
        $inscripcion = Inscripcion::find($id);  //se puede filtrar

        return view('pago.index', ['inscripcion' => $inscripcion,'pagos' => $pagos,'total' => $total]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //cuando presiona borrar una cuota
        $pago = Pago::find($id);
        $inscripcion_id = $pago->inscripcion_id;
        $pago->delete();

        $total = Pago::where('inscripcion_id',$pago->inscripcion_id)->sum('importe');
        $inscripcion = Inscripcion::find($inscripcion_id);
        if(($total >= 5000 && $inscripcion->promo == "sinpromo") || ($total >= 8000 && $inscripcion->promo == "almuerzo")){
            $inscripcion->completado = 1;
        }else{
            $inscripcion->completado = 0;
        }
        $inscripcion->save();

        return redirect('/pago/'.$inscripcion_id);
    }
}
