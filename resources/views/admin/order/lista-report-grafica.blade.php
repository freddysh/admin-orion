@php
    use Khill\Lavacharts\Lavacharts;
@endphp
@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">ORDENES</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{route('reserva.lista')}}">REPORT</a></li>

@endsection
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="row">
    <div class="col">
    </div>
</div>
<div class="row">
    <div class="col-12">
            <div id="temps_div"></div>
            {!! $lava->render('LineChart', 'Temps', 'temps_div') !!}
    </div>
</div>


@endsection
