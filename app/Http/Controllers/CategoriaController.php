<?php

namespace App\Http\Controllers;

use App\categoria;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $categoria = DB::table('categorias')
        ->where('estado', 1)
        ->get();
        return $categoria;
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
            'nombre'  => 'required|string',
            'descripcion'  => 'nullable|string',
            'url_imagen'     => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
          ]);

          if(($request->url_imagen)!=null){
            $t=time();
            $nombre=$request->nombre;
            $imageName = $t.'_'.$nombre.'.'.$request->url_imagen->extension();
            $request->url_imagen->move(public_path('images/categorias'), $imageName);
           }else{
            $imageName=null;
           }

        $categoria = new Categoria([
            
            'nombre'    => $request->nombre,
            'descripcion'    => $request->descripcion,
            'url_imagen'  => $imageName
        ]);

        $categoria->save();
        return response()->json([
            'data'=>$categoria,
            'message' => 'Categoria creado!'], 201);
  
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
     * @param  \App\categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $categoria = DB::table('categorias')->where('id', $id)
        ->where('estado', 1)
        ->get();
       
        if(json_decode($categoria, true) ){
            return $categoria;

        }else{
            return response()->json([
                'message' => 'Esa Categoria no existe!'], 200);
        }   
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $categoria = Categoria::findOrFail($request->id);

        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
      
        $categoria->save();

        /* return $users; */
        return response()->json([
            'message' => 'Categoria actualizado!'], 200);
      
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $categoria = Categoria::findOrFail($id);

        $categoria->estado = 0;
      
        $categoria->save();
        if(json_decode($categoria, true) ){
            return response()->json([
                'message' => 'categoria eliminado!'], 200);

        }else{
            return response()->json([
                'message' => 'Esa categoria no existe!'], 200);
        }   
    }
}
