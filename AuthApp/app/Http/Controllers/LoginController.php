<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected function credentials(Request $request)
{
    $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
    $password = $request->password;

    return ['email' => $email, 'password' => $password];
}

protected function validateLogin(Request $request)
{
    $request->validate([
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8',
    ]);
}
}
