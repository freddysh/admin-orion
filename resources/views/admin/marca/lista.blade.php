@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item active" aria-current="page">MARCAS</li>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-9">
                                <b class="text-danger text-15">LISTA DE MARCAS</b>
                            </div>
                            <div class="col-3 text-right">
                                <a href="{{ route('marca_nuevo_path') }}" class="btn btn-info text-white"><i class="fas fa-plus-circle"></i> AGREGAR MARCA</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <table class="table table-bordered table-hover table-striped">
                            <thead >
                                <tr>
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th>OPERACIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($brands as $item)
                                    <tr id="row_lista_marcas_{{ $item->id }}">
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#categoriaModal_{{ $item->id }}">
                                                    <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="categoriaModal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <form action="{{ route('marca_editar_path') }}" method="POST" method="POST" enctype="multipart/form-data">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Editar datos</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group col-12">
                                                                    <label for="nombre">Nombre</label>
                                                                    <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombre" placeholder="Nombre de la comunidad" value="{{ $item->name }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer text-right">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                            <a href="#" class="btn btn-danger" onclick="eliminar_marca('{{ $item->id }}')"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
