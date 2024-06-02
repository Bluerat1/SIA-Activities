<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use session;
use App\Http\Requests\RegisterRequest;
use App\Rules\StrongPassword;


class UserController extends Controller 
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
 
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }



    protected function create(array $data)
    {
        $data['name'] = trim($data['name']);
        $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }



    protected function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        // Further logic to log in the user
    }


    public function showLoginForm()
{
    return view('auth.login');
}
 
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



 
