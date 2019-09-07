@php
  use Carbon\Carbon;
@endphp
@if (!isset($hotel_proveedor_id))
  @php
      $hotel_proveedor_id=0;
  @endphp
@endif
@if (!isset($categoria))
  @php
      $categoria='TRANSPORTE';
  @endphp
@endif
@if (!isset($reserva_id))
  @php
      $reserva_id=0;
  @endphp
@endif
@if (!isset($f1))
  @php
      $fecha=new Carbon();
      $fecha->subHour(5);
      $f1=$fecha->format('Y-m-d');
  @endphp
@endif
@if (!isset($f2))
  @php
      $fecha=new Carbon();
      $fecha->subHour(5);
      $f2=$fecha->format('Y-m-d');
  @endphp
@endif
@if (!isset($asociacion_id))
  @php
      $asociacion_id=1;
  @endphp
@endif
@if (!isset($order_id))
  @php
      $order_id=1;
  @endphp
@endif
@if (!isset($anio))
  @php
      $fecha=new Carbon();
      $fecha->subHour(5);
      $anio=$fecha->format('Y');
  @endphp
@endif
<div class="menu-list text-12">

  <ul id="menu-content" class="menu-content collapsed menu1 sidebar-nav">
        <li class="sidebar-brand1 sidebar-wrap">
            <a href="#">
                <img alt="Brand" src="{{asset("images/img/orion.jpg")}}" class="w-75">
            </a>
            <a href="#!">
                 <b class="text-primary text-12">
                    {{Auth::user()->name}}
                </b>
                <b class="text-primary  text-13">Eres un(a)
                  @if(Auth::user()->hasRole('admin')){{'Administrador'}}@elseif(Auth::user()->hasRole('asociacion')){{ 'Asociacion' }}@endif
                  </b>
            </a>
         </li>

    {{-- rutas para la base de datos --}}
    <li data-toggle="collapse" data-target="#operaciones" class="collapsed">
        <a href="#" class="bg-dark text-white"><i class="fas fa-database"></i> BASE DE DATOS </a>
    </li>
    @if(Auth::user()->hasRole('admin'))
    <ul class="sub-menu collapse menu2 @if(
      (url()->current()==route('administrador_lista_path')||url()->current()==route('administrador_nuevo_path'))||
      (url()->current()==route('categoria_lista_path')||url()->current()==route('categoria_nuevo_path'))||
      (url()->current()==route('marca_lista_path')||url()->current()==route('marca_nuevo_path'))||
      (url()->current()==route('product_lista_path')||url()->current()==route('product_nuevo_path'))
      ) show @endif" id="operaciones">
      <li data-toggle="collapse" class="active1">
          <a class="@if(url()->current()==route('administrador_lista_path')||url()->current()==route('administrador_nuevo_path')) active @endif" href="{{route('administrador_lista_path')}}">ADMINISTRADORES</a>
        </li>
      <hr>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('categoria_lista_path')||url()->current()==route('categoria_nuevo_path')) active @endif" href="{{route('categoria_lista_path')}}">CATEGORIAS</a>
      </li>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('marca_lista_path')||url()->current()==route('marca_nuevo_path')) active @endif" href="{{route('marca_lista_path')}}">MARCAS</a>
      </li>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('product_lista_path')||url()->current()==route('product_nuevo_path')) active @endif" href="{{route('product_lista_path')}}">PRODUCTOS</a>
      </li>

    </ul>
    @elseif(Auth::user()->hasRole('asociacion'))

    @endif
    {{-- rutas para la base de datos --}}
    <li data-toggle="collapse" data-target="#reservas" class="collapsed">
      <a href="#" class="bg-danger text-white"><i class="fas fa-swatchbook"></i> VENTAS </a>
    </li>
        <ul class="sub-menu collapse menu2 @if(
            (url()->current()==route('reserva.lista')||url()->current()==route('reserva.detalle',[$reserva_id]))||
            (url()->current()==route('ordenes.lista',[$f1,$f2])||url()->current()==route('reserva.detalle',[$order_id]))||
            (url()->current()==route('operaciones.lista',[$f1,$f2])||url()->current()==route('operaciones.post.lista'))||
            (url()->current()==route('encuesta.lista')||url()->current()==route('encuesta.detalle',[$reserva_id]))
            ) show @endif" id="reservas">
                <li data-toggle="collapse" class="active1">
                <a class="@if(url()->current()==route('ordenes.lista')||url()->current()==route('ordenes.post.lista')) active @endif" href="{{route('ordenes.lista')}}">ORDENES</a>
                </li>
                <li data-toggle="collapse" class="active1">
                    <a class="@if(url()->current()==route('ordenes.lista.report',[$f1,$f2])||url()->current()==route('ordenes.post.lista')) active @endif" href="{{route('ordenes.lista.report',[$f1,$f2])}}">REPORTE DE VENTAS</a>
                </li>
                <li data-toggle="collapse" class="active1">
                    <a class="@if(url()->current()==route('ordenes.lista.report.grafica',$anio)||url()->current()==route('ordenes.post.lista')) active @endif" href="{{route('ordenes.lista.report.grafica',$anio)}}">GRAFICA DE VENTAS</a>
                </li>
        </ul>
  </ul>
</div>
