@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="{{ route('wnioski.addStep11p') }}" method="POST">
        @csrf
          <fieldset class="authFieldset">
            <legend>
              {{ __('Zasoby papierowe') }}  
            </legend>
            <div class="newDevice">
              <label for="windows" class="windows">{{ __('Przetwarzane dokumenty papierowe:') }}</label>
            </div>
            <div class="newDevice" id="zaspap">
            @foreach($dzialy as $dzialZ)
              <div class="zaspapDzial">
                @if (@isset(Session::get('dzialZaspap')[$dzialZ->id_dz]) && Session::get('dzialZaspap')[$dzialZ->id_dz] == true)
                  <input type="checkbox" name="dzialZaspap[{{ $dzialZ->id_dz }}]" checked 
                    onclick="document.getElementById({{ $dzialZ->id_dz }}).style.display = this.checked? 'inline' : 'block'; "> 
                @else 
                  <input type="checkbox" name="dzialZaspap[{{ $dzialZ->id_dz }}]"
                    onclick="document.getElementById({{ $dzialZ->id_dz }}).style.display = this.checked? 'inline' : 'none'; "> 
                @endif
                <label for="$dzialZ->id_dz">
                  {{ __($dzialZ->symbol_d)}}
                </label>
                
              </div>
              @if (@isset(Session::get('dzialZaspap')[$dzialZ->id_dz]) && Session::get('dzialZaspap')[$dzialZ->id_dz] == true)
                <div class="zaspapDIV" id="{{ $dzialZ->id_dz }}" style="display:block;">
              @else  
                <div class="ZaspapDIV" id="{{ $dzialZ->id_dz }}" style="display:none;">
              @endif
                <div class="ZaspapTable">
                  <table>
                    <tr>
                      <th>Dokument</th>
                      <th>Poziom dostepu</th>
                    </tr>
                  @foreach($zaspap as $zaspapDok)
                    @if($dzialZ->id_dz == $zaspapDok->id_dz)
                      <tr>
                        <td>
                          {{ __($zaspapDok->nazwa_zaspap) }}
                        </td>
                        <td>
                          <select name="zaspapSelect[{{ $zaspapDok->id_zaspap }}]" class="zaspapSelect" required>
                            @if (@isset(Session::get('zaspapSelect')[$zaspapDok->id_zaspap]) && Session::get('zaspapSelect')[$zaspapDok->id_zaspap] == '1')
                              <option value="0">BRAK</option>
                              <option value="1" selected="selected">Wgląd</option>
                              <option value="2">Modyfkacja</option>
                              <option value="3">Usuwanie</option>
                            @elseif (@isset(Session::get('zaspapSelect')[$zaspapDok->id_zaspap]) && Session::get('zaspapSelect')[$zaspapDok->id_zaspap] == '2')
                              <option value="0">BRAK</option>
                              <option value="1" >Wgląd</option>
                              <option value="2" selected="selected">Modyfikacja</option>
                              <option value="3">Usuwanie</option>
                            @elseif (@isset(Session::get('zaspapSelect')[$zaspapDok->id_zaspap]) && Session::get('zaspapSelect')[$zaspapDok->id_zaspap] == '2')
                              <option value="0">BRAK</option>
                              <option value="1" >Wgląd</option>
                              <option value="2" >Modyfikacja</option>
                              <option value="3" selected="selected">Usuwanie</option>                            
                            @else
                              <option value="0" selected>BRAK</option>
                              <option value="1">Wgląd</option>
                              <option value="2">Modyfikacja</option>
                              <option value="2">Usuwanie</option>
                            @endif
                          </select>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                </table>
              </div>
            </div>
            @endforeach
            </div>
            <button type="submit" class="wniosekDalejButton">
              {{ __('Dalej') }}
            </button>
          </form>
        <span class="editButton"> 
          <a class ="devLink" href="{{ route('wnioski.addStep10') }}">WRÓĆ</a>
        </span>
    </fieldset>
    </div>
  </div>
@endsection