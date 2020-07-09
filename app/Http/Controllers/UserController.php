<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Resources\UserResource;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::all();
        return $users;
    }

    
    public function show($id)
    {
      $users = DB::table('users')->where('id', $id)->get();
       
        if(json_decode($users, true) ){
                return $users;   

              /*  return response()->json([
                'data1' => $users,
                'data2' =>$users
            ], 200); */
              
            /* UserResource::withoutWrapping();
            return new UserResource(User::find($id)); */ 

        }else{
            return response()->json([
                'message' => 'Ese usuario no existe!'], 200);
        }   
        
    }

    public function update(Request $request)
    {
       /*  $users = DB::table('users')->where('email', $request->$email)->get();
 */

    $users = User::findOrFail($request->id);

        $users->nombre = $request->nombre;
        $users->apellido = $request->apellido;
        $users->direccion = $request->direccion;
        $users->fecha_nacimiento = $request->fecha_nacimiento;
        $users->telefono = $request->telefono;
        $users->email = $request->email;
        $users->admin = $request->admin;
        $users->latitud = $request->latitud;
        $users->longitud = $request->longitud;
        $users->password = bcrypt($request->password);

        $users->save();

        /* return $users; */
        return response()->json([
            'message' => 'Usuario actualizado!'], 200);
      
    }

    public function destroy($id)
    {
        $users = DB::table('users')->where('id', $id)->delete();
        if(json_decode($users, true) ){
            return response()->json([
                'message' => 'Usuario eliminado!'], 200);

        }else{
            return response()->json([
                'message' => 'Ese usuario no existe!'], 200);
        }   
   }
}