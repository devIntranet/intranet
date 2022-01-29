@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper dzial-det">
    <h1>
    {{ $dzial->nazwa_d }}
    </h1>
    <p class="class symbol">
    {{ $dzial->symbol_d }}
    </p>
    <p class="class user">
    {{ $dzial->id_u }}
    </p>
  </div>
  
  </div>
@endsection