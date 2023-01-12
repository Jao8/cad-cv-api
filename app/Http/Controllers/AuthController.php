<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __invoke(Request $request)
    {
//        $fields = $request->validate([
//            'email' => 'required|string',
//            'password' => 'required|string'
//        ]);
//
//        // Check email
//        $user = User::where('email', $fields['email'])->first();
//
//        // Check password
//        if(!$user || !Hash::check($fields['password'], $user->password)) {
//            return response([
//                'message' => 'Bad creds'
//            ], 401);
//        }
//
//        $token = $user->createToken('myapptoken')->plainTextToken;
//
//        $response = [
//            'user' => $user,
//            'token' => $token
//        ];

        if(!auth()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException('error login -> '. $request['email'].'/'.$request['password']);
        }
    }
}
