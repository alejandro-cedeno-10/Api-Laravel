<?php

namespace App\Http\Controllers;

use App\tamano;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class TamanoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $tamano = Tamano::all();
        return $tamano;
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
            'nombre'     => 'required|string',
    
        ]);

        $tamano = new Tamano([
            
            'nombre'    => $request->nombre
            
        ]);

        $tamano->save();
        return response()->json([
            'data'=>$tamano,
            'message' => 'Tamano creado!'], 201);
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
     * @param  \App\tamano  $tamano
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $tamano = DB::table('tamanos')->where('id', $id)->get();
       
        if(json_decode($tamano, true) ){
            return $tamano;

        }else{
            return response()->json([
                'message' => 'Ese tamano no existe!'], 200);
        }   
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tamano  $tamano
     * @return \Illuminate\Http\Response
     */
    public function edit(tamano $tamano)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tamano  $tamano
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $tamano = Tamano::findOrFail($request->id);

        $tamano->nombre = $request->nombre;
      
        $tamano->save();

        /* return $users; */
        return response()->json([
            'message' => 'Tamano actualizado!'], 200);
      
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tamano  $tamano
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tamano = DB::table('tamanos')->where('id', $id)->delete();
        if(json_decode($tamano, true) ){
            return response()->json([
                'message' => 'Tamano eliminado!'], 200);

        }else{
            return response()->json([
                'message' => 'Ese Tamano no existe!'], 200);
        }   
    }
}
