@extends('adminlte::page')

@section('title', 'Cadastro de Usuário')

@section('content_header')
    <h1>Cadastro de Usuário</h1>
@endsection

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                <h5>
                    <i class="icon fas fa-ban"></i>
                    Ocorreu um erro.
                </h5>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
<!-- form -->
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('users.store' )}}" method="POST">
                @csrf
                <div class="box-body">
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Nome Completo</label>
                        <div class="col-sm-10">
                            <input type="text" value="{{old('name')}}" name="name" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" value="{{old('email')}}" name="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Senha</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword" placeholder="Digite sua Senha">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPasswordConf" class="col-sm-2 col-form-label">Confirmação da Senha</label>
                        <div class="col-sm-10">
                            <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" id="inputPasswordConf" placeholder="Digite sua Senha novamente">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer form-group row text-right">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10">
                            <a href="/admin/users" class="btn btn-sm btn-outline-danger">Cancelar</a>
                            <button type="submit" class="btn btn-sm btn-success pull-right">Cadastrar</button>
                        </div>
                </div>
            <!-- /.box-footer -->
            </form>
        </div>
    </div>

@endsection
