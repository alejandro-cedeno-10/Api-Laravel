<?php

namespace App\Http\Controllers;

use App\tipo_pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TipoPagoController extends Controller
{/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
      
        $tipo_pagos = Tipo_pago::all();
        return $tipo_pagos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $request->validate([
            'tipo_pago'     => 'required|string',
          
        ]);
        $tipo_pagos = new Tipo_pago([
            
            'tipo_pago'    => $request->tipo_pago
            
        ]);

        $tipo_pagos->save();
        return response()->json([
            'data'=>$tipo_pagos,
            'message' => 'Tipos_pagos creado!'], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipo_pago  $tipo_pago
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $tipo_pagos = DB::table('tipo_pagos')->where('id', $id)->get();
       
        if(json_decode($tipo_pagos, true) ){
            return $tipo_pagos;

        }else{
            return response()->json([
                'message' => 'Ese tipo_pagos no existe!'], 200);
        }   
        
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipo_pago  $tipo_pago
     * @return \Illuminate\Http\Response
     */
     public function edit()
    {
        //
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipo_pago  $tipo_pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $request->validate([
            'id'  => 'required|numeric',
            'tipo_pago'     => 'required|string',
          
        ]);

        $tipo_pagos = Tipo_pago::findOrFail($request->id);

        $tipo_pagos->tipo_pago = $request->tipo_pago;
      
        $tipo_pagos->save();

        /* return $users; */
        return response()->json([
            'message' => 'Tipo_pago actualizado!'], 200);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipo_pago  $tipo_pago
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tipo_pagos = DB::table('tipo_pagos')->where('id', $id)->delete();
        if(json_decode($tipo_pagos, true) ){
            return response()->json([
                'message' => 'Tipo_pagos eliminado!'], 200);

        }else{
            return response()->json([
                'message' => 'Ese tipo_pago no existe!'], 200);
        }   
    }
}
