<?php

namespace App\Http\Controllers;

use App\modo_pago;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ModoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $modo_pagos = Modo_pago::all();
        return $modo_pagos;
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
            'id_tipo'     => 'required|numeric',
<<<<<<< HEAD
            'pago'     => 'required|numeric',
            'detalles'     => 'string'
=======
            'pago'     => 'nullable|numeric',
            'detalles'     => 'nullable|string'
>>>>>>> aede34b... 'V5'
                  
        ]);
        $modo_pagos = new Modo_pago([
            
            'id_tipo'    => $request->id_tipo,
            'pago'    => $request->pago,
            'detalles'    => $request->detalles
            
        ]);

        $modo_pagos->save();
        return response()->json([
            'data'=>$modo_pagos,
            'message' => 'Modo_Pago creado!'], 201);
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
     * @param  \App\modo_pago  $modo_pago
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $modo_pagos = DB::table('modo_pagos')->where('id', $id)->get();
       
        if(json_decode($modo_pagos, true) ){
            return $modo_pagos;

        }else{
            return response()->json([
                'message' => 'Ese modo_pagos no existe!'], 200);
        }   
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\modo_pago  $modo_pago
     * @return \Illuminate\Http\Response
     */
    public function edit(modo_pago $modo_pago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\modo_pago  $modo_pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $modo_pagos = Modo_pago::findOrFail($request->id);

      
        $modo_pagos->pago = $request->pago;
        $modo_pagos->detalles = $request->detalles;
      
        $modo_pagos->save();

        /* return $users; */
        return response()->json([
            'message' => 'Modo_pagos actualizado!'], 200);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\modo_pago  $modo_pago
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $modo_pagos = DB::table('modo_pagos')->where('id', $id)->delete();
        if(json_decode($modo_pagos, true) ){
            return response()->json([
                'message' => 'Modo_pagos eliminado!'], 200);

        }else{
            return response()->json([
                'message' => 'Ese Modo_pagos no existe!'], 200);
        }   
    }
}
