@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item"><a href="{{ route('comunidad_lista_path') }}">PRODUCTOS</a></li>
<li class="breadcrumb-item active" aria-current="page">NUEVO</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <b class="text-primary text-15">NUEVO PRODUCTO</b>
                    </div>
                    <div class="col-12">
                        <form action="{{ route('product_store_path') }}" method="POST" enctype="multipart/form-data">
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
                                        <label for="marca">Marca</label>
                                        <select class="form-control" id="marca" name="marca">
                                            @foreach ($brands->sortBy('name') as $item)
                                                <option value="{{ $item->id }}" @if(old('marca')== $item->name){{ 'selected' }}@endif >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" aria-describedby="nombre" placeholder="COMUNIDAD DE ..." required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="altura">Altura</label>
                                        <input type="text" class="form-control" id="altura" name="altura" value="{{ old('altura') }}" aria-describedby="altura" placeholder="3420 msnm" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="distancia">Distancia</label>
                                        <input type="text" class="form-control" id="distancia" name="distancia" value="{{ old('distancia') }}" aria-describedby="distancia" placeholder="2 horas de la ciudad del Cusco" required>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="descripcion">Descripcion</label>
                                        <textarea  id="basic-example" class="form-control descripcion" name="descripcion" id="descripcion" cols="30" rows="10">{{ old('descripcion') }}</textarea>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="historia">Historia</label>
                                        <textarea class="form-control descripcion" name="historia" id="historia" cols="30" rows="10">{{ old('historia') }}</textarea>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="foto">Portada</label>
                                        <input type="file" name="portada" class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="miniatura">Miniatura</label>
                                        <input type="file" name="miniatura" class="form-control">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="foto">Galeria de fotos</label>
                                        <input type="file" name="foto[]" multiple class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                {{ csrf_field() }}
                                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> GUARDAR</button>
                                <a href="{{ route('comunidad_lista_path') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
