<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\DB;
use PDF;

class PDFController extends Controller
{
    /**
     * Creacion del Informe PDF
     */
    public function getPDF(Request $request)
    {
        $fecha_hoy =  date("d/m/Y");

        $membresia = $request->get('membresia'); //todas, local, interior, otra_iglesia
        $completado = $request->get('completado'); //todas, completo, incompleto
        $promo = $request->get('promo'); //todas, abrilmayo, juniojulio, sinpromo, cuotas
        if ($request->get('promo') == "todas") {
            $promo_op = "<>";
        } else {
            $promo_op = "=";
        }
        if ($request->get('membresia') == "todas") {
            $membresia_op = "<>";
        } else {
            $membresia_op = "=";
        }
        if ($request->get('completado') == "todas") {
            $completado_op = "<>";
        } else {
            $completado_op = "=";
        }
        $inscripciones = DB::table('inscripcions')
            ->where('promo', $promo_op, $promo)
            ->where('membresia', $membresia_op, $membresia)
            ->where('completado', $completado_op, $completado)
            ->orderBy('nro_entrada', 'asc')
            ->get();

        $pdf = PDF::loadView(
            'inscripcion.PDF_Example',
            [
                'inscripciones' => $inscripciones,
                'fecha' => $fecha_hoy,
                'membresia' => $membresia,
                'promo' => $promo,
                'completado' => $completado,
                'inscriptas_total' => ($request->get('inscriptas_total')),
                'total_pagos' => ($request->get('total_pagos')),
                'pago_completo' => ($request->get('pago_completo'))
            ]
        )
            ->setPaper('a4', 'landscape')
            ->setWarnings(false);
        return $pdf->download('PDF_reporte_'. $fecha_hoy.'.pdf');
    }
}