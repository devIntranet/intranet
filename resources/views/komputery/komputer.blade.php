@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  @foreach($nazwa as $komp)
    Komputer - {{ $komp }}<br>
  @endforeach

  </div>
@endsection