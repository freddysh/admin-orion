@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item active" aria-current="page">CATEGORIAS</li>
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
                                <b class="text-danger text-15">LISTA DE CATEGORIAS</b>
                            </div>
                            <div class="col-3 text-right">
                                <a href="{{ route('categoria_nuevo_path') }}" class="btn btn-info text-white"><i class="fas fa-plus-circle"></i> AGREGAR CATEGORIA</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <table class="table table-bordered table-hover table-striped">
                            <thead >
                                <tr>
                                    <th>#</th>
                                    <th>PADRE</th>
                                    <th>NOMBRE</th>
                                    <th>OPERACIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($categorias as $item)
                                    <tr id="row_lista_comunidades_{{ $item->id }}">
                                        <td>{{ $i }}</td>
                                        <td>
                                            @if ($item->father_id==0)
                                                PADRE
                                            @else
                                                {{ $categorias->where('id',$item->father_id)->first()->name}}
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#categoriaModal_{{ $item->id }}">
                                                    <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="categoriaModal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <form action="{{ route('categoria_editar_path') }}" method="POST" method="POST" enctype="multipart/form-data">
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
                                                                    <label for="childs">Padre</label>
                                                                    <select class="form-control" id="padre" name="padre">
                                                                        <option value="0">Padre</option>
                                                                        @foreach ($categorias as $item_)
                                                                            <option value="{{ $item_->id }}" @if($item_->id==$item->father_id) {{ 'selected' }} @endif>{{ $item_->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-12">
                                                                    <label for="nombre">Nombre</label>
                                                                    <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombre" placeholder="Nombre de la comunidad" value="{{ $item->name }}">
                                                                </div>

                                                                    <div class="col-12">
                                                                        <div class="row">
                                                                        <div class="form-group col-12 text-left">
                                                                            <p><b>Foto</b></p>
{{--                                                                            @foreach ($item->fotos->where('estado','1') as $foto)--}}
                                                                                @if (Storage::disk('categorias')->has($item->photo))
                                                                                    <figure class="figure m-3" id="{{ $item->id.'_'.$item->id }}">
                                                                                        <img src="{{ route('categoria_editar_imagen_path',$item->photo) }}" class="figure-img rounded" alt="A generic" width="200px" height="200px">
                                                                                        <figcaption class="figure-caption text-right mt-0">
                                                                                            <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_cliente('{{ $item->id.'_'.$item->id }}')">
                                                                                                <i class="fas fa-trash-alt"></i>
                                                                                            </a>
                                                                                        </figcaption>
                                                                                        <input type="hidden" name="portada" value="{{ $item->id }}">
                                                                                    </figure>
                                                                                @endif
{{--                                                                            @endforeach--}}
                                                                        </div>
                                                                        <div class="form-group col-12">
                                                                            <label for="foto">Foto</label>
                                                                            <input type="file" name="portada_f" class="form-control">
                                                                        </div>
                                                                    </div>
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
                                            <a href="#" class="btn btn-danger" onclick="eliminar_categoria('{{ $item->id }}')"><i class="fas fa-trash-alt"></i></a>
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
