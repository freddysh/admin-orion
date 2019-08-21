<option>Escoja un opcion</option>
@if(!empty($provincias))
  @foreach($provincias as $value)
    <option value="{{ $value->id }}">{{ $value->provincia }}</option>
  @endforeach
@endif
