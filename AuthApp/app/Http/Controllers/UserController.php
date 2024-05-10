<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use session;

class UserController extends Controller 
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
 
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
 
        return redirect('/login')->with('success', 'Registration successful! Please log in.');
    }

    public function showLoginForm()
{
    return view('auth.login');
}
 
    public function login(Request $request)
    {
    $credentials = $request->only('email', 'password');
 
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }
 
            return redirect('/login')->with('error', 'Invalid credentials. Please try again.');
    }



    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }





    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }



/**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return redirect('dashboard');
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }


    public function logout() {
       
        Auth::logout();
  
        return Redirect('login');
    }


}



 
