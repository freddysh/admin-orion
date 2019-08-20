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
      (url()->current()==route('comunidad_lista_path')||url()->current()==route('comunidad_nuevo_path'))||
      (url()->current()==route('asociacion.lista')||url()->current()==route('asociacion.nuevo'))||
      (url()->current()==route('servicios.nuevo',[$asociacion_id])||url()->current()==route('servicios.lista',[$asociacion_id]))||
      (url()->current()==route('proveedor.nuevo',[$categoria])||url()->current()==route('proveedor.lista'))||
      (url()->current()==route('producto.nuevo',[$categoria])||url()->current()==route('producto.lista'))||
      (url()->current()==route('solucitudes.asociacion.lista')||url()->current()==route('solucitudes.otros.lista'))
      ) show @endif" id="operaciones">
      <li data-toggle="collapse" class="active1">
          <a class="@if(url()->current()==route('administrador_lista_path')||url()->current()==route('administrador_nuevo_path')) active @endif" href="{{route('administrador_lista_path')}}">ADMINISTRADORES</a>
        </li>
      <hr>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('categoria_lista_path')||url()->current()==route('categoria_nuevo_path')) active @endif" href="{{route('categoria_lista_path')}}">CATEGORIAS</a>
      </li>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('comunidad_lista_path')||url()->current()==route('comunidad_nuevo_path')) active @endif" href="{{route('comunidad_lista_path')}}">COMUNIDADES</a>
      </li>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('asociacion.lista')||url()->current()==route('asociacion.nuevo') || url()->current()==route('servicios.nuevo',[$asociacion_id])||url()->current()==route('servicios.lista',[$asociacion_id])) active @endif" href="{{route('asociacion.lista')}}"> ASOCIACIONES</a>
      </li>
      {{-- <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('servicios.nuevo',[$asociacion_id])||url()->current()==route('servicios.lista',[$asociacion_id])) active @endif" href="{{route('servicios.lista',[$asociacion_id])}}">SERVICIOS</a>
      </li> --}}
      <hr>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('proveedor.nuevo',[$categoria])||url()->current()==route('proveedor.lista')) active @endif" href="{{route('proveedor.lista')}}">PROVEEDORES</a>
      </li>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('producto.nuevo',[$categoria])||url()->current()==route('producto.lista')) active @endif" href="{{route('producto.lista')}}">PRODUCTOS</a>
      </li>
      <hr>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('solucitudes.asociacion.lista')) active @endif" href="{{route('solucitudes.asociacion.lista')}}">SOLICITUDES ASOCIACIONES</a>
      </li>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('solucitudes.otros.lista')) active @endif" href="{{route('solucitudes.otros.lista')}}">SOLICITUDES TRANSP.&GUIAS</a>
      </li>
    </ul>
    @elseif(Auth::user()->hasRole('asociacion'))
    <ul class="sub-menu collapse menu2 @if(
      (url()->current()==route('servicios.nuevo',[Auth::user()->id])||url()->current()==route('servicios.lista',[Auth::user()->id]))
      ) show @endif" id="operaciones">

      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('servicios.nuevo',[Auth::user()->id])||url()->current()==route('servicios.lista',[Auth::user()->id])) active @endif" href="{{route('servicios.lista',[Auth::user()->id])}}"> MIS SERVICIOS</a>
      </li>

    </ul>
    @endif
    {{-- rutas para la base de datos --}}
    <li data-toggle="collapse" data-target="#reservas" class="collapsed">
      <a href="#" class="bg-danger text-white"><i class="fas fa-swatchbook"></i> RESERVAS </a>
    </li>
        <ul class="sub-menu collapse menu2 @if(
            (url()->current()==route('reserva.lista')||url()->current()==route('reserva.detalle',[$reserva_id]))||
            (url()->current()==route('operaciones.lista',[$f1,$f2])||url()->current()==route('operaciones.post.lista'))||
            (url()->current()==route('encuesta.lista')||url()->current()==route('encuesta.detalle',[$reserva_id]))
            ) show @endif" id="reservas">
            <li data-toggle="collapse" class="active1">
            <a class="@if(url()->current()==route('reserva.lista')||url()->current()==route('reserva.detalle',[$reserva_id])) active @endif" href="{{route('reserva.lista')}}">RESERVAS</a>
            </li>
            @if(Auth::user()->hasRole('admin'))
                <li data-toggle="collapse" class="active1">
                <a class="@if(url()->current()==route('operaciones.lista',[$f1,$f2])||url()->current()==route('operaciones.post.lista')) active @endif" href="{{route('operaciones.lista',[$f1,$f2])}}">OPERACIONES</a>
                </li>
                <li data-toggle="collapse" class="active1">
                    <a class="@if(url()->current()==route('encuesta.lista')||url()->current()==route('encuesta.detalle',[$reserva_id])) active @endif" href="{{route('encuesta.lista')}}">ENCUESTAS</a>
                    </li>
                {{--  <li data-toggle="collapse" class="active1">
                    <a class="@if(url()->current()==route('encuesta.lista')||url()->current()==route('encuesta.detalle',[$encuesta_id])) active @endif" href="{{route('encuesta.lista')}}">ENCUESTAS</a>
                </li>  --}}
            @endif
        </ul>
  </ul>
</div>
