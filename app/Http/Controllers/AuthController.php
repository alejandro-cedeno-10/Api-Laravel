<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function signup(Request $request)
    {
        $request->validate([
            'nombre'     => 'required|string',
            'apellido'     => 'required|string',
            'direccion'=> 'nullable|string',
            'fecha_nacimiento'=> 'nullable|date',
            'telefono'=> 'nullable|numeric',
            'admin'=> 'numeric',
            'latitud'=> 'nullable|numeric',
            'longitud'=> 'nullable|numeric',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string',
            'c_password' => 'required|string|same:password'      
        ]);
        $user = new User([
            'nombre'     => $request->nombre,
            'apellido'     => $request->apellido,
            'direccion'     => $request->direccion,
            'fecha_nacimiento'     => $request->fecha_nacimiento,
            'telefono'     => $request->telefono,
            'admin'     => $request->admin,
            'email'    => $request->email,
            'latitud'    => $request->latitud,
            'longitud'    => $request->longitud,
            'password' => bcrypt($request->password),
        ]);
        $user->save();
        return response()->json([
            'data'=>$user,
            'message' => 'Usuario creado!'], 201);
    } 


    


    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
        ]);
    }



    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 
            'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
