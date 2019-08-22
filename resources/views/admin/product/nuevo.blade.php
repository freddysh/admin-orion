@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item"><a href="{{ route('product_lista_path') }}">PRODUCTOS</a></li>
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
                                    <div class="form-group col-6">
                                        <label for="marca">Marca</label>
                                        <select class="form-control" id="marca" name="marca">
                                            @foreach ($brands->sortBy('state','1')->sortBy('name') as $item)
                                                <option value="{{ $item->id }}" @if(old('marca')== $item->name){{ 'selected' }}@endif >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="categoria">Categoria</label>
                                        <select class="form-control" id="categoria" name="categoria">
                                            @foreach ($categories->sortBy('state','1')->sortBy('name') as $item)
                                                <option value="{{ $item->id }}" @if(old('categoria')== $item->name){{ 'selected' }}@endif >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="codigo">Codigo</label>
                                        <input type="text" class="form-control" id="codigo" name="codigo" value="{{ old('codigo') }}" aria-describedby="codigo" placeholder="Codigo" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" aria-describedby="nombre" placeholder="Nombre" required>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="descripcion">Descripcion</label>
                                        <textarea  id="basic-example" class="form-control descripcion" name="descripcion" id="descripcion" cols="30" rows="10">{{ old('descripcion') }}</textarea>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="detalle">Detalle</label>
                                        <textarea class="form-control descripcion" name="detalle" id="detalle" cols="30" rows="10">{{ old('detalle') }}</textarea>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="precio">Precio regular</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="precio" name="precio" value="{{ old('precio') }}" aria-describedby="precio" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="precio_online">Precio online</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="precio_online" name="precio_online" value="{{ old('precio_online') }}" aria-describedby="precio online" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="foto">Portada <span class="text-primary">(150x150px)</span></label>
                                        <input type="file" name="portada" class="form-control">
                                    </div>
                                    <div class="form-group col-6 d-none">
                                        <label for="miniatura">Miniatura</label>
                                        <input type="file" name="miniatura" class="form-control">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="foto">Galeria de fotos<span class="text-primary">(300x300px)</span></label>
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
