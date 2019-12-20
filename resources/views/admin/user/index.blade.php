@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>
        Usuários Cadastrados
        <a href="{{route('users.create')}}" class="btn btn-sm btn-outline-success">Novo Usuário</a>
    </h1>
@endsection
@section('content')
<table class="table table-hover table-responsive">
    <thead>
        <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Açoes</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <a href="{{route('users.edit', ['user' => $user->id])}}" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="{{route('users.destroy', ['user' => $user->id])}}" class="btn btn-sm btn-danger">Excluir</a>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" align="right">Total de Usuários: {{count($users)}}</td>
            </tr>
        </tbody>
</table>
@endsection
