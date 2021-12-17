<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    /** Api logout
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout(Request $request)
    {
        if(auth()->check()){
            $user = User::find(auth()->user()->uuid);
            return  $user->tokens()->delete() ? response()->json('Logout feito com sucesso',200) : response()->json('Erro ao fazer logout',403);
        }
        return  response()->json('Erro ao fazer logout',403);
    }


    /**
     * Api login
     * @param \App\Http\Requests\Api\LoginRequest $request
     * @return array
     */

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email ou senha incorretas.'],
            ]);
        }
        return ['token'=>$user->createToken($user->uuid)->plainTextToken];
    }
}
