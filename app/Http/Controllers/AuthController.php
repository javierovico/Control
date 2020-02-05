<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'usuario'     => 'required|string|unique:users',
            'password' => 'required|string|confirmed',
//            'nombre' => 'required|string',
//            'apellido' => 'required|string',
        ]);
        $user = new User([
            'usuario'     => $request->usuario,
//            'email'    => $request->email,
            'password' => bcrypt($request->password),
//            'nombre'   => $request->nombre,
//            'apellido' => $request->apellido,
//            'telefono' => $request->telefono
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'usuario'       => 'required|string',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['usuario', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }else{
            $token->expires_at = Carbon::now()->addDay(1);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
//            'es_doctor'    => ($user->doctor)!=null,
//            'es_admin'     => ($user->admin)!=null,
//            'cedula'        => $user->cedula,
            'id'            => $user->id,
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
        $usuario = $request->user();
        $usuario->doctor;   //actualiza
        $usuario->admin;
        return response()->json($usuario);
//        return response()->json(['user'=>$request->user(), 'request'=>$request]);
    }
}
