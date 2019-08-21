@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item"><a href="{{ route('marca_lista_path') }}">MARCAS</a></li>
<li class="breadcrumb-item active" aria-current="page">NUEVO</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <b class="text-primary text-15">NUEVA MARCA</b>
                    </div>
                    <div class="col-12">
                        <form action="{{ route('marca_store_path') }}" method="POST" enctype="multipart/form-data">
                            <div class="col-12">
                                @if(session()->has('success'))
                                    <div class="alert alert-success" role="alert">
                                        <strong>Genial!</strong> {{ session('success') }}
                                    </div>
                                @elseif(session()->has('error'))
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Ups!</strong> {{ session('error') }}
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" aria-describedby="nombre" placeholder="NOMBRE DE LA MARCA" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                {{ csrf_field() }}
                                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> GUARDAR</button>
                                <a href="{{ route('marca_lista_path') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
