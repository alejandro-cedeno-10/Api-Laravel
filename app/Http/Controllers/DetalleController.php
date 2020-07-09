<?php

namespace App\Http\Controllers;

use App\detalle;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class DetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $detalle = Detalle::all();
        return $detalle;
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
            'id_factura'     => 'required|numeric',
            'id_producto'     => 'required|numeric',
            'cantidad'    => 'required|numeric',
            'precio' => 'required|numeric',
                  
        ]);

        $detalle = new Detalle([
            
            'id_factura'    => $request->id_factura,
            'id_producto'    => $request->id_producto,
            'cantidad'    => $request->cantidad,
            'precio'    => $request->precio
            
        ]);

        $detalle->save();

       
            $data=[
                'data'=>[
                'id_factura'=>$request->id_factura,
                'id_producto'=>$request->id_producto,
                'cantidad'=>$request->cantidad,
                'precio'=>$request->precio,
                
                ],
                'message' => 'Detalle creado!'
            ];
        


        return $data;
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
     * @param  \App\detalle  $detalle
     * @return \Illuminate\Http\Response
     */
    public function show($id_factura)
    {
        //
        $detalle = DB::table('detalles')->where('id_factura', $id_factura)->get();
       
        if(json_decode($detalle, true) ){
            return $detalle;

        }else{
            return response()->json([
                'message' => 'Esa factura no existe!'], 200);
        }   
        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\detalle  $detalle
     * @return \Illuminate\Http\Response
     */
    public function edit(detalle $detalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\detalle  $detalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $detalle = DB::table('detalles')
        ->where('id_factura', $request->id_factura)
        ->where('id_producto', $request->id_producto)
        ->update(['cantidad' => $request->cantidad,'precio' => $request->precio]);
     


        /* return $users; */
        return response()->json([
            'message' => 'Detalle actualizado!'], 200);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\detalle  $detalle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id2)
    {
        //
        $detalle = DB::table('detalles')
        ->where('id_factura', $id)
        ->where('id_producto', $id2)
        ->delete();
        if(json_decode($detalle, true) ){
            return response()->json([
                'message' => 'Detalle eliminado!'], 200);

        }else{
            return response()->json([
                'message' => 'Ese Detalle no existe!'], 200);
        }   
    }
}
