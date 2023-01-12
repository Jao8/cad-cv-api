<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __invoke(Request $request)
    {
        if(!auth()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException('error login -> '. $request['email'].'/'.$request['password']);
        }
    }
}
