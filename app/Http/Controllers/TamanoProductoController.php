<?php

namespace App\Http\Controllers;

use App\tamano_producto;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class TamanoProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tamano_producto = DB::table('tamano_productos')
        ->where('estado', 1)
        ->get();
        return $tamano_producto;
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
            'id_tamano'     => 'required|numeric',
            'id_producto'     => 'required|numeric',
            'precio'     => 'required|numeric',
<<<<<<< HEAD
            'stock'=> 'numeric'
=======
            'stock'=> 'nullable|numeric'
>>>>>>> aede34b... 'V5'
           //Los demas son opcionales
        ]);
        
        $tamano_producto = new Tamano_producto([
            
            'id_tamano'    => $request->id_tamano,
            'id_producto'    => $request->id_producto,
            'precio'    => $request->precio,
            'stock'    => $request->stock
            
        ]);



        $tamano_producto->save();


        $data=[
            'data'=>[
            'id_tamano'=>$request->id_tamano,
            'id_producto'=>$request->id_producto,
            'precio'=>$request->precio,
            'stock'=>$request->stock,
            
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
     * @param  \App\tamano_producto  $tamano_producto
     * @return \Illuminate\Http\Response
     */
    public function show($id_producto)
    {
        //
        $tamano_producto = DB::table('tamano_productos')
        ->where('estado', 1)
        ->where('id_producto', $id_producto)->get();
       
        if(json_decode($tamano_producto, true) ){
            return $tamano_producto;

        }else{
            return response()->json([
                'message' => 'Ese tamano_producto no existe!'], 200);
        }   
        
    }
    
    public function showTamanoProduto($id_producto)
    {
        //
       
        $producto = DB::table('productos')->where('id', $id_producto)
        ->where('estado', 1)
        ->get();
        $tamanos = DB::table('tamanos')
            ->join('tamano_productos', function ($join){
            $join-> on('tamanos.id','=', 'tamano_productos.id_tamano');
            })
            ->where('tamano_productos.id_producto','=', $id_producto) 
            ->where('tamano_productos.estado', 1) 
            ->get();
       
        if(json_decode($tamanos, true) ){
           
             foreach($producto as $clave =>$valor){
                $data=[
                    'Producto'=>[
                    'Nombre_producto'=>$valor->nombre,
                    'id_producto'=>$valor->id,
                    'id_categoria'=>$valor->id_categoria,
                    'Descripcion'=>$valor->descripcion,
                    'Imagen'=>$valor->url_imagen
                    ],
                    'Tamanos_disponibles'=>[],
                ];
            }
            foreach($tamanos as $clave =>$valor){
                $data['Tamanos_disponibles'][$clave]=[
                    'Id_tamano'=>$valor->id,
                    'Tamano'=>$valor->nombre,
                    'Precio'=>$valor->precio,
                    'Stock'=>$valor->stock,
            ];
            }

 
                return $data;

        }else{
            return response()->json([
                'message' => 'Este producto no tiene tamanos disponibles!'], 200);
        }   
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tamano_producto  $tamano_producto
     * @return \Illuminate\Http\Response
     */
    public function edit(tamano_producto $tamano_producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tamano_producto  $tamano_producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $tamano_producto = DB::table('tamano_productos')
        ->where('id_tamano', $request->id_tamano)
        ->where('id_producto', $request->id_producto)
        ->update(['precio' => $request->precio,'stock' => $request->stock]);
     


        /* return $users; */
        return response()->json([
            'message' => 'Tamano producto actualizado!'], 200);
      
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tamano_producto  $tamano_producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id2)
    {
        //

        $tamano_producto = DB::table('tamano_productos')
        ->where('id_tamano', $id)
<<<<<<< HEAD
        ->where('id_producto', $id_producto)
=======
        ->where('id_producto', $id2)
>>>>>>> aede34b... 'V5'
        ->update(['estado' => 0]);
     
      
        if(json_decode($tamano_producto, true) ){
            return response()->json([
                'message' => 'Tamano_producto eliminado!'], 200);

        }else{
            return response()->json([
                'message' => 'Ese Tamano_producto no existe!'], 200);
        }   
    }
}
