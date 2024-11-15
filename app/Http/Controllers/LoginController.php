<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        Log::info('Iniciando el proceso de autenticacion.');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('app')->plainTextToken;
            $arr = array(
                'acceso' => 'Ok',
                'error' => '',
                'token' => $token,
                'idUsuario' => $user->id,
                'nombreUsuario' => $user->name
            );

             Log::info('Proceso finalizado. Autenticación realizada con exito');

            return json_encode($arr);
        } else {
            $arr = array(
                'acceso' => '',
                'token' => '',
                'error' => 'No existe el usuario y/o contraseña.',
                'idUsuario' => 0,
                'nombreUsuario' => ''
            );
            Log::info('Proceso finalizado. Autenticación fallida');

            return json_encode($arr);
        }
    }
}
