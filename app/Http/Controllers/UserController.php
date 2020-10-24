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

    public function indexAdmin(Request $request)
    {
        $users = DB::table('users')->where('admin', 1)->get();
        return $users;
    }

    public function indexUsers(Request $request)
    {
        $users = DB::table('users')->where('admin', 0)->get();
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
    
    $user = User::findOrFail($request->id);

    $bandera = false;

			if ($request->nombre!= null)
			{
				$user->nombre = $request->nombre ;
				$bandera=true;
			}

			if ($request->apellido!= null)
			{	
				$user->apellido = $request->apellido;
				$bandera=true;
			}

            if ($request->direccion!= null)
			{
				$user->direccion = $request->direccion;
				$bandera=true;
            }

            if ($request->fecha_nacimiento!= null)
			{
				$user->fecha_nacimiento = $request->fecha_nacimiento;
				$bandera=true;
            }
            
            if ($request->telefono!= null)
			{
				$user->telefono = $request->telefono;
				$bandera=true;
            }
            
            if ($request->admin!= null)
			{
				$user->admin = $request->admin;
				$bandera=true;
            }

            if ($request->latitud!= null)
			{
				$user->latitud = $request->latitud;
				$bandera=true;
            }

            if ($request->longitud!= null)
			{
				$user->longitud = $request->longitud;
				$bandera=true;
            }
            
			if ($request->email!= null)
			{
				$request->validate([
					'email'    => 'required|string|email|unique:users,email',
				]);
		
				$user->email = $request->email;
				$bandera=true;
			}

			if ($request->password!= null)
			{
				$request->validate([
					'password' => 'required|string|confirmed',
                ]);
                
                $password_tem=bcrypt($request->old_password);

                if($user->password=$password_tem){
                    $user->password=bcrypt($request->password);
				    $bandera=true;
                }
                else{
                    return response()->json([
                        'errors'=>array(['
                        status'=>false,
                        'message'=>'Password incorrecta'])
                    ],200);
                }
				
				
			}

			if ($bandera)
			{
				$user->save();
				return response()->json([
					'status'=>true,
                    'data'=>$user,
                    'message'=>'User Actualizado'],200);
			}
			else
			{
				return response()->json([
					'errors'=>array(['
					status'=>false,
					'message'=>'No se ha modificado ningún dato.'])
				],200);
			}
      
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