@extends('layout.master')



@section('content')  
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Cadastro</a></li> 
                </ol>
            </div> 
        </div> 
    </div> 
</div>

<div class="content">
    <div class="container-fluid">   
        <form method="POST" action="{{ route('cadastro.post') }}" aria-label="Cadastrar"> 
            @csrf 
            <div class="row"> 
                <div class="col-lg-12"> 
                    <div class="card  card-outline" v-bind:class="[color ? color : 'card-primary']" > 
                        <div class="card-body">  
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" id="nome" name="nome" class="form-control {{ $errors->has('nome') ? ' is-invalid' : '' }}" value="{{old('nome')}}" required>  
                                @if ($errors->has('nome'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                @endif
                            </div> 
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" id="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{old('email')}}" required> 
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div> 
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label for="id">CPF:</label>
                                        <input type="number" id="id" name="id" class="form-control {{ $errors->has('id') ? ' is-invalid' : '' }}" value="{{old('id')}}" required> 
                                        @if ($errors->has('id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('id') }}</strong>
                                            </span>
                                        @endif
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apelido">Apelido:</label>
                                        <input type="text" id="apelido" name="apelido" class="form-control {{ $errors->has('apelido') ? ' is-invalid' : '' }}" value="{{old('apelido')}}" required> 
                                        @if ($errors->has('apelido'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('apelido') }}</strong>
                                            </span>
                                        @endif
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label for="password">Senha:</label>
                                        <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"   required> 
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div> 
                                </div>
                                <div class="col-md-6">  
                                    <div class="form-group">
                                       <label for="passwordConfirm">Confirmar Senha:</label>
                                        <input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control {{ $errors->has('passwordConfirm') ? ' is-invalid' : '' }}"   required> 
                                        @if ($errors->has('passwordConfirm'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('passwordConfirm') }}</strong>
                                            </span>
                                        @endif 
                                    </div> 
                                </div>
                            </div>

                        </div> 

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">
                                Cadastrar
                            </button> 
                        </div> 
                    </div>
                </div>
            </div> 
        </form> 
    </div>
</div>
@endsection

