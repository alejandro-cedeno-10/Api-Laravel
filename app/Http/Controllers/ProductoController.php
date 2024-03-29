<?php

namespace App\Http\Controllers;

use App\producto;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index(Request $request)
    {
        $producto = DB::table('productos')
        ->where('estado', 1)
        ->get();
        return $producto;
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
            'id_categoria'     => 'required|numeric',
            'nombre'     => 'required|string',
            'descripcion'     => 'nullable|string',
            'url_imagen'     => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            
           //Los demas son opcionales
        ]);

        if(($request->url_imagen)!=null){
        $t=time();
        $nombre=$request->nombre;
        $imageName = $t.'_'.$nombre.'.'.$request->url_imagen->extension();
        $request->url_imagen->move(public_path('images/productos'), $imageName);
       }else{
        $imageName=null;
       }


        $producto = new Producto([
            
            'id_categoria'    => $request->id_categoria,
            'nombre'    => $request->nombre,
            'descripcion'    => $request->descripcion,
            'url_imagen'    => $imageName
            
        ]);

        $producto->save();
        return response()->json([
            'data'=>$producto,
            'message' => 'Producto creado!'], 201);
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
     * @param  \App\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $producto = DB::table('productos')
        ->where('estado', 1)
        ->where('id', $id)->get();
       
        if(json_decode($producto, true) ){
            return $producto;

        }else{
            return response()->json([
                'message' => 'Ese producto no existe!'], 200);
        }   
        
    }

    public function show_Productos_Admin($id)
    {
        //
        $producto = DB::table('productos')->select('id', 'id_categoria','nombre','descripcion','url_imagen')->where('id_categoria', $id)
        ->where('estado', 1)
        ->get();

           
     

        $categoria = DB::table('categorias')->select('id', 'nombre','descripcion')
        ->where('estado', 1)
        ->where('id', $id)->get();
       

        if(json_decode($producto, true) ){
         
            foreach($categoria as $clave =>$valor){
            $data=[
                'Categoria'=>[
                'Nombre_categoria'=>$valor->nombre,
                'id'=>$valor->id,
                'Descripcion'=>$valor->descripcion,
                ],
                'Productos'=>$producto,
            ];
        }

            return $data;

        }else{
            return response()->json([
                'message' => 'Esa caterogia no existe!'], 200);
        }   
        
    }

    public function show_Productos($id)
    {
        //
        /* $producto = DB::table('productos')->select('id', 'id_categoria','nombre','descripcion','url_imagen')->where('id_categoria', $id)
        ->where('estado', 1)
        ->get();
 */

        $producto = DB::table('productos')
        ->select('productos.*',DB::raw('COUNT(tamano_productos.estado) as numero_Presentaciones'))     
        ->join('tamano_productos', 'tamano_productos.id_producto', '=', 'productos.id')
        ->groupBy('productos.id','productos.id_categoria','productos.nombre','productos.descripcion','productos.url_imagen','productos.created_at','productos.updated_at','productos.estado')
        ->where('productos.id_categoria', $id)
        ->where('productos.estado', 1)
        ->where('tamano_productos.estado', 1)
        
        ->get();

        $categoria = DB::table('categorias')->select('id', 'nombre','descripcion')
        ->where('estado', 1)
        ->where('id', $id)->get();
       

        if(json_decode($producto, true) ){
         
            foreach($categoria as $clave =>$valor){
            $data=[
                'Categoria'=>[
                'Nombre_categoria'=>$valor->nombre,
                'id'=>$valor->id,
                'Descripcion'=>$valor->descripcion,
                ],
                'Productos'=>$producto,
            ];
        }

            return $data;

        }else{
            return response()->json([
                'message' => 'Esa caterogia no existe!'], 200);
        }   
        
    }

    public function show_Productos_Combos()
    {
        $combo="Combos";
        $id=null;
        $categoria = DB::table('categorias')
        ->where('estado', 1)
        ->where('nombre', $combo)->get();
             
        foreach($categoria as $clave =>$valor){
            $dataTemp=[
                'id'=>$valor->id
            ];
            }
        
        $id= $dataTemp['id'];    
        $dataTemp=null;

        $producto = DB::table('productos')
        ->select('productos.*',DB::raw('COUNT(tamano_productos.estado) as numero_Presentaciones'))     
        ->join('tamano_productos', 'tamano_productos.id_producto', '=', 'productos.id')
        ->groupBy('productos.id','productos.id_categoria','productos.nombre','productos.descripcion','productos.url_imagen','productos.created_at','productos.updated_at','productos.estado')
        ->where('productos.id_categoria', $id)
        ->where('productos.estado', 1)
        ->where('tamano_productos.estado', 1)
        
        ->get();

        return $producto;

        if(json_decode($producto, true) ){
         
            foreach($categoria as $clave =>$valor){
            $data=[
                'Categoria'=>[
                'Nombre_categoria'=>$valor->nombre,
                'id'=>$valor->id,
                'Descripcion'=>$valor->descripcion,
                ],
                'Productos'=>$producto,
            ];
        }

            return $data;

        }else{
            return response()->json([
                'message' => 'Esa categoria no tiene producto!'], 200);
        }   
        
    }




    
    public function filter_productos(Request $request)
    {
        //
       $bandera=false;
        $producto = DB::table('productos')
      
        ->select('productos.id', 'productos.id_categoria','productos.nombre','productos.descripcion','productos.url_imagen')
        ->Orwhere('productos.nombre', 'like','%'.$request->buscar.'%')
        ->Orwhere('productos.descripcion', 'like','%'.$request->buscar.'%')
        ->where('productos.estado', 1)
        ->get();
        
        foreach($producto as $clave =>$valor){
            $bandera=true;
        break;
        }

        if($bandera){
        
       $categoria= DB::table('categorias')
       ->select('categorias.nombre','categorias.id','categorias.descripcion')
       ->where('categorias.id','=',$valor->id_categoria)
       ->where('categorias.estado', 1)
       ->get();
       
       }
       else{

        $categoria=DB::table('categorias')
        ->select('categorias.nombre','categorias.id','categorias.descripcion')
        ->Orwhere('categorias.nombre', 'like','%'.$request->buscar.'%')
        ->Orwhere('categorias.descripcion', 'like','%'.$request->buscar.'%')
        ->where('categorias.estado', 1)
        ->get();



         $producto = DB::table('productos')
        ->join('categorias', function ($join){
            $join-> on('productos.id_categoria','=', 'categorias.id');    
               })
        ->select('productos.nombre','productos.id','productos.descripcion','productos.url_imagen','productos.descripcion','productos.url_imagen')
        ->Orwhere('categorias.nombre', 'like','%'.$request->buscar.'%')
        ->Orwhere('categorias.descripcion', 'like','%'.$request->buscar.'%') 
        ->where('productos.estado', 1)
        ->get();
       } 
  
       
        if(json_decode($producto, true) ){
         
             foreach($categoria as $clave =>$valor){
            $data=[
                'Categoria'=>[
                'Nombre_categoria'=>$valor->nombre,
                'id'=>$valor->id,
                'Descripcion'=>$valor->descripcion,
                ]
            ];
            

        }
        
        foreach($producto as $clave =>$valor){
            $data['Productos_relacionados'][$clave]=[
                'Nombre'=>$valor->nombre,
                'id'=>$valor->id,
                'Descripcion'=>$valor->descripcion,
                'url_imagen'=>$valor->url_imagen,
        ];
        }
 
            
        return $data;

        }else{
            return response()->json([
                'message' => 'Coincidencias no encontradas!'], 200);
        }   
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $request->validate([
            'id'     => 'required|numeric',
            
        ]);

        $producto = Producto::findOrFail($request->id);
 
        if(($request->url_imagen)!=null){
            $request->validate([
                'url_imagen'     => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', 
            ]);
            
            if(($producto->url_imagen)!=null){
            $dirimgs = public_path().'/images/productos/'.$producto->url_imagen;
            @unlink($dirimgs);
            } 

            $t=time();
            $nombre=$producto->nombre;
            $imageName = $t.'_'.$nombre.'.'.$request->url_imagen->extension();
            $request->url_imagen->move(public_path('images/productos'), $imageName);
            $producto->url_imagen = $imageName;
        }

            if( $request->nombre != null) {
                $producto->nombre = $request->nombre;
            }
         
            if( $request->descripcion != null) {
            $producto->descripcion = $request->descripcion;
           }

        $producto->save();

        /* return $users; */
        return response()->json([
            'message' => 'Producto actualizado!'], 200);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        

        $producto = Producto::findOrFail($id);

        $producto->estado = 0;
      
        $producto->save();

        if(json_decode($producto, true) ){
            return response()->json([
                'message' => 'Producto eliminado!'], 200);

        }else{
            return response()->json([
                'message' => 'Ese Producto no existe!'], 200);
        }   
    }
}
