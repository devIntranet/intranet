@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
    <h1 class="">
    Dodaj nowy Komputer
    </h1>
    <form action="">
    <label for="nazwa" class="boo">Nazwa Komputera</label>
    <input type="text" id="nazwa" name="dns_k">
    <label for="typ" class="boo">Nazwa Komputera</label>
    <input type="text" id="typ" name="typ_k">
    <label for="ip" class="boo">Nazwa Komputera</label>
    <input type="text" id="ip" name="ip_k">
    <label for="nr" class="boo">Nazwa Komputera</label>
    <input type="text" id="nr" name="inwent_k">
    <label for="data" class="boo">Nazwa Komputera</label>
    <input type="text" id="data" name="data_k">
    <label for="dzial" class="boo">Nazwa Komputera</label>
    <select name="id_d" id="dzial">
      @foreach($dzialy as $dzial)
      <option value=" {{ $dzial['id_d'] }}">{{ $dzial['nazwa_d'] }}</option>
      @endforeach
    </select>
    <label for="user" class="boo">Nazwa Komputera</label>
    <input type=text" id="user" name="id_u">
    <input type="submit" class="submit">
    </form>

    </div>
  </div>
@endsection