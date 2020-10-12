<?php

namespace App\Http\Controllers;

use App\factura;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index(Request $request)
    {
      
        $factura = Factura::all();
        return $factura;
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
            'id_user'     => 'required|numeric',
            'num_pago'     => 'required|numeric',
            'fecha'    => 'required|date'
                  
        ]);
        $factura = new Factura([
            
            'id_user'    => $request->id_user,
            'num_pago'    => $request->num_pago,
            'fecha'    => $request->fecha
            
        ]);

        $factura->save();
        return response()->json([
            'data'=>$factura,
            'message' => 'Factura creada!'], 201);
    }

    public function showFacturaOne($id_factura, $id_user)
    {
        //
        $user= DB::table('users')
        ->select('id','nombre','apellido','direccion','telefono','email')
        ->where('id', '=',$id_user)
         ->get();
        
       
         $factura = DB::table('facturas')
        ->join('modo_pagos', function ($join){
            $join-> on('facturas.num_pago','=', 'modo_pagos.id')    
            ->join('tipo_pagos', function ($join){
                $join-> on('modo_pagos.id_tipo','=', 'tipo_pagos.id');    
                   });       
        })
         ->select('tipo_pagos.tipo_pago','modo_pagos.pago'
         ,'modo_pagos.detalles','modo_pagos.id as id_modo_pago',
         'tipo_pagos.id as id_tipo_pago'
         ,'facturas.id as id_factura'
         ,'facturas.fecha')
         ->where('facturas.id', '=',$id_factura)
          ->get(); 
        

         $detalle = DB::table('detalles')
        ->join('productos', function ($join){
            $join-> on('productos.id','=', 'detalles.id_producto');    
               })
        ->select('detalles.id_producto','detalles.cantidad','detalles.precio'
        ,'productos.nombre','productos.descripcion')
        ->where('detalles.id_factura', '=',$id_factura)
        ->get();

      
        if(json_decode($detalle, true) ){
           
        foreach($user as $clave =>$valor){
          $data=[
                    'Usuario'=>[
                    'nombre'=>$valor->nombre,
                    'id'=>$valor->id,
                    'apellido'=>$valor->apellido,
                    'direccion'=>$valor->direccion,
                    'telefono'=>$valor->telefono,
                    'email'=>$valor->email
                    ]
                ];
            }
            foreach($factura as $clave =>$valor){
                $data['Factura']=[
                    'id_y_Num_factura'=>$valor->id_factura,
                    'fecha'=>$valor->fecha
            ];
            }

            foreach($factura as $clave =>$valor){
                $data['Pago']=[
                    'id_y_num_pago'=>$valor->id_modo_pago,
                    'Pago_del_cliente'=>$valor->pago,
                    'Detalles'=>$valor->detalles,
                    'Tipo_pago'=>$valor->tipo_pago
            ];
            }

            foreach($detalle as $clave =>$valor){
                $data['Productos'][$clave]=[
                    'Id_producto'=>$valor->id_producto,
                    'Nombre'=>$valor->nombre,
                    'Descripcion'=>$valor->descripcion,
                    'Cantidad'=>$valor->cantidad,
                    'Total'=>$valor->precio
            ];
            } 
           

            
 
                return $data;

       }else{
            return response()->json([
                'message' => 'La factura esta vacia o no existe!'], 200);
        }   
        
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
     * @param  \App\factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $factura = DB::table('facturas')->where('id', $id)->get();
       
        if(json_decode($factura, true) ){
            return $factura;

        }else{
            return response()->json([
                'message' => 'Esa factura no existe!'], 200);
        }   
        
    }

    public function FacUserOne($id_user)
    {
        //
        $factura = DB::table('facturas')
        ->join('modo_pagos', function ($join){
            $join-> on('facturas.num_pago','=', 'modo_pagos.id')    
            ->join('tipo_pagos', function ($join){
                $join-> on('modo_pagos.id_tipo','=', 'tipo_pagos.id');    
                   });       
        })
         ->select('facturas.id_user','tipo_pagos.tipo_pago','modo_pagos.pago'
         ,'modo_pagos.detalles','modo_pagos.id as id_modo_pago',
        'facturas.id as id_factura'
         ,'facturas.fecha')
         ->where('facturas.id_user', '=',$id_user)
          ->get(); 
           
        if(json_decode($factura, true) ){

            foreach($factura as $clave =>$valor){
                $data['Facturas']=[
                    'id_user'=>$valor->id_user,
                    'id_factura'=>$valor->id_factura,
                    'id_y_num_pago'=>$valor->id_modo_pago,
                    'Pago_del_cliente'=>$valor->pago,
                    'Detalles'=>$valor->detalles,
                    'Tipo_pago'=>$valor->tipo_pago
            ];
            }
            return $factura;

        }else{
            return response()->json([
                'message' => 'Este usuario no tiene facturas!'], 200);
        }   
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(factura $factura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $request->validate([
            'id'     => 'required|numeric',
            'fecha'    => 'required|date'
                  
        ]);

        $factura = Factura::findOrFail($request->id);

        $factura->fecha = $request->fecha;
      
        $factura->save();

        /* return $users; */
        return response()->json([
            'message' => 'Factura actualizada!'], 200);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $factura = DB::table('facturas')->where('id', $id)->delete();
        if(json_decode($factura, true) ){
            return response()->json([
                'message' => 'Factura eliminado!'], 200);

        }else{
            return response()->json([
                'message' => 'Esa Factura no existe!'], 200);
        }   
    }
}
