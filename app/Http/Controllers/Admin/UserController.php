<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        $loggedId = Auth::id();

        return view('admin.user.index', [
            'users' => $users,
            'loggedId' => $loggedId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);

        $validation = Validator::make($data,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed']
        ]);

        if($validation->fails()){
            return redirect()->route('users.create')
            ->withErrors($validation)
            ->withInput();
        }

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if($user){
            return view('admin.user.edit', [
                'user' => $user
            ]);
        }else{
            return redirect()->route('users.index')
            ->withErrors(['user' => 'O Usuário não existe.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if($user){
            $data = $request->only([
                'name',
                'email',
                'password',
                'password_confirmation'
            ]);

            $validator = Validator::make([
                'name' => $data['name'],
                'email' => $data['email']
            ],[
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);

            if($validator->fails()){
                return redirect()->route('users.edit', [
                    'user' => $id
                ])
                ->withErrors($validator);
            }

            $user->name = $data['name'];

            if($user->email != $data['email']){
                $emailExists = User::where('email', $data['email'])->get();

                if(count($emailExists) > 0){
                    $validator->errors()->add('email', 'Já existe um usuário com este e-mail!');
                    return redirect()->route('users.edit', [
                        'user' => $id
                    ])
                    ->withErrors($validator);
                }

                $user->email = $data['email'];

            }

            if(!empty($data['password'])){
                if(strlen($data['password']) >= 4){
                    if($data['password'] === $data['password_confirmation']){
                        $user->password = Hash::make($data['password']);
                    }else{
                        $validator->errors()->add('password', 'As senhas não coincidem.');
                        return redirect()->route('users.edit', [
                            'user' => $id
                        ])
                        ->withErrors($validator);
                    }
                }else{
                    $validator->errors()->add('password', 'A senha deve conter 4 ou mais caracteres.');
                    return redirect()->route('users.edit', [
                        'user' => $id
                    ])
                    ->withErrors($validator);
                }
            }

            $user->save();
            return redirect()->route('users.index');
        }

        return redirect()->route('users.index')
        ->withErrors(['user' => 'O Usuário não existe.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedUser = Auth::id();

        if($loggedUser != $id){
            $userExists = User::find($id);

            if(count($userExists) > 0){
                $userExists->delete();
                return redirect()->route('users.index');
            }

            return redirect()->route('users.index')
            ->withErrors(['user' => 'O Usuário não existe.']);
        }

        return redirect()->route('users.index')
        ->withErrors(['user' => 'Não é permitido excluir o usuário logado no sistema.']);


    }
}
