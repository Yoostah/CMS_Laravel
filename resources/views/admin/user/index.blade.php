@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>
        Usuários Cadastrados
        <a href="{{route('users.create')}}" class="btn btn-sm btn-outline-success">Novo Usuário</a>
    </h1>
@endsection
@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <a href="{{route('users.edit', ['user' => $user->id])}}" class="btn btn-sm btn-outline-primary">Editar</a>
                        @if($loggedId != $user->id)
                        <form class="d-inline" method="POST" action="{{route('users.destroy', ['user' => $user->id])}}" onsubmit="return confirm('Deseja excluir o usuário?')">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" align="right">Total de Usuários: {{count($users)}}</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
<div class="float-right" style="align-self: end;">
    {{$users->links()}}
</div>



@endsection
