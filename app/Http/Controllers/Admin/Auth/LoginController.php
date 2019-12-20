<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(){
        return view('admin.login');
    }

    public function login(Request $request){
        $user = $request->only(['email', 'password']);

        $remember = $request->input('remember', false);

        $logar = $this->validator($user);

        if($logar->fails()){
            return redirect()->route('login')
            ->withErrors($logar)
            ->withInput();
        }

        if(Auth::attempt($user, $remember)){
            return redirect()->route('admin.home');
        }else{
            $logar->errors()->add('password', 'E-mail e/ou senha inválidos!');

            return redirect()->route('login')
            ->withErrors($logar)
            ->withInput();
        }

    }

    public function validator(array $data){
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:4']
        ]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
