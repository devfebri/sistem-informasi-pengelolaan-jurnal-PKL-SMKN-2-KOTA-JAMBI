<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login2');
    }

    protected function redirectTo()
    {
        return '/dashboard';
    }
    
    public function username()
    {
        return 'username';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(\Illuminate\Http\Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');
        
        // Determine field type
        $field = 'username';
        if (is_numeric($login)) {
            // If numeric, check if it's NISN (students) or NIP (teachers)
            if (strlen($login) >= 10) {
                $field = 'nisn'; // NISN for students
            } else {
                $field = 'nip'; // NIP for teachers  
            }
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        }
        
        return [
            $field => $login,
            'password' => $password,
        ];
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Username/NISN/NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);
    }
}
