<option>Escoja un opcion</option>
@if(!empty($distritos))
  @foreach($distritos as $value)
    <option value="{{ $value->id }}">{{ $value->distrito }}</option>
  @endforeach
@endif
