@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  @foreach($dzialy as $dzial)
    {{ $dzial['nazwa_d'] }} - {{ $dzial['symbol_d'] }} - {{ $dzial['id_u'] }}<br>
  @endforeach
  </div>
@endsection