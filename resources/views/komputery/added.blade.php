@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <h1 class="">
        Dodałeś
      </h1>
      <div>
      {{ $komputer->id_k}} <br>
      {{ $komputer->dns_k }}<br>
      {{ $komputer->ip_k }}<br>
      {{ $komputer->typ_k }}<br>
      </div>
    </div>
  </div>
@endsection