@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item active" aria-current="page">ADMINISTRADORES</li>
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
                                <b class="text-danger text-15">LISTA DE ADMINISTRADORES</b>
                            </div>
                            <div class="col-3 text-right">
                                <a href="{{ route('administrador_nuevo_path') }}" class="btn btn-info text-white"><i class="fas fa-plus-circle"></i> AGREGAR</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <table class="table table-bordered table-hover table-striped">
                            <thead >
                                <tr>
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th>CELULAR</th>
                                    <th>EMAIL</th>
                                    <th>ESTADO</th>
                                    <th>OPERACIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($administradores as $item)
                                    <tr id="row_lista_comunidades_{{ $item->id }}">
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->celular }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            @if($item->state=='1')
                                                <span class="badge badge-success">Activo</span>
                                            @elseif($item->state=='0')
                                                <span class="badge badge-dark">Suspendido</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#comunidadModal_{{ $item->id }}">
                                                    <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="comunidadModal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <form action="{{ route('administrador_editar_path') }}" method="POST" method="POST" enctype="multipart/form-data">
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
                                                                <div class="form-group col-12">
                                                                        <label for="celular">Celular</label>
                                                                        <input type="text" class="form-control" id="celular" name="celular" aria-describedby="celular" placeholder="Celular" value="{{ $item->celular }}">
                                                                </div>
                                                                <div class="form-group col-12">
                                                                        <label for="email">Email</label>
                                                                        <input type="text" class="form-control" id="email" name="email" aria-describedby="email" placeholder="email" value="{{ $item->email }}">
                                                                </div>
                                                                <div class="form-group col-6">
                                                                        <label for="password">Password</label>
                                                                        <input type="password" class="form-control" id="password" name="password" aria-describedby="password" placeholder="password" value="{{ $item->password2 }}">
                                                                </div>
                                                                <div class="form-group col-6">
                                                                        <label for="password_2">Re-password</label>
                                                                        <input type="password" class="form-control" id="password_2" name="re_password" aria-describedby="password" placeholder="password" value="{{ $item->password2 }}">
                                                                </div>
                                                                <div class="form-group col-3">
                                                                    <label for="email">
                                                                    <input type="radio" class="form-control" id="estado_1" name="estado" value="1" @if($item->state=='1'){{'checked="checked"'}}@endif>
                                                                    Activo</label>
                                                                </div>
                                                                <div class="form-group col-3">
                                                                    <label for="email">
                                                                    <input type="radio" class="form-control" id="estado_0" name="estado" value="0"  @if($item->state=='0'){{'checked="checked"'}}@endif>
                                                                    Suspendido</label>
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
                                            <a href="#" class="btn btn-danger" onclick="eliminar_administrador('{{ $item->id }}')"><i class="fas fa-trash-alt"></i></a>
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
