@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
    <script>
        function udSelectCheck(udSelect) {
          if(udSelect){
            udEnabledValue = document.getElementById("udEnabled").value;
            if(udEnabledValue == udSelect.value){
                document.getElementById("udzialy").style.display = "block";
            }
            else{
                document.getElementById("udzialy").style.display = "none";
            }
          }
          else{
              document.getElementById("udzialy").style.display = "none";
          }
        }
      </script>
      <form action="{{ route('wnioski.addStep2p') }}" method="POST">
        @csrf
          <fieldset class="authFieldset">
            <legend>
              {{ __('Środowisko Windows') }}  
            </legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Konto w systemie Windows') }}</label>
              </div>
              <div class="newDevice">
                <select name="windows" id="windows" class="devDetSelect" onchange="udSelectCheck(this);">
                @if (Session::has('windows') && Session::get('windows') == 1) 
                  <option id="udEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="udEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('windows')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            
            @if (Session::has('windows') && Session::get('windows') == 1) 
              <div class="udzialy" id="udzialy" style="display:block;">
            @else 
              <div class="udzialy" id="udzialy" style="display:none;">
            @endif
              {{ __('Udziały Sieciowe:') }}
              @foreach($dzialy as $dzialU)
                <div class="udzialyDzial">
                  @if (@isset(Session::get('dzialShare')[$dzialU->id_dz]) && Session::get('dzialShare')[$dzialU->id_dz] == true)
                    <input type="checkbox" name="dzialShare[{{ $dzialU->id_dz }}]" checked 
                      onclick="document.getElementById({{ $dzialU->id_dz }}).style.display = this.checked? 'inline' : 'none'; "> 
                  @else 
                    <input type="checkbox" name="dzialShare[{{ $dzialU->id_dz }}]"
                      onclick="document.getElementById({{ $dzialU->id_dz }}).style.display = this.checked? 'inline' : 'none'; "> 
                  @endif
                  <label for="$dzialU->id_dz">
                    {{ __($dzialU->symbol_d)}}
                  </label>
                  
                </div>
                @if (@isset(Session::get('dzialShare')[$dzialU->id_dz]) && Session::get('dzialShare')[$dzialU->id_dz] == true)
                  <div class="udzialy" id="{{ $dzialU->id_dz }}" style="display:block;">
                @else  
                  <div class="udzialy" id="{{ $dzialU->id_dz }}" style="display:none;">
                @endif
                  <div class="netShareTable">
                    <table>
                      <tr>
                        <th>Udział</th>
                        <th>Poziom dostepu</th>
                      </tr>
                    @foreach($udzialy as $udzial)
                      @if($dzialU->id_dz == $udzial->id_dz)
                        <tr>
                          <td>
                            {{ __($udzial->nazwa_ud) }}
                          </td>
                          <td>
                            <select name="share[{{ $udzial->id_ud }}]" id="shares" class="shareSelect" required>
                              @if (@isset(Session::get('share')[$udzial->id_ud]) && Session::get('share')[$udzial->id_ud] == '1')
                                <option value="0">BRAK</option>
                                <option value="1" selected="selected">Odczyt</option>
                                <option value="2">Zapis</option>
                              @elseif (@isset(Session::get('share')[$udzial->id_ud]) && Session::get('share')[$udzial->id_ud] == '2')
                                <option value="0">BRAK</option>
                                <option value="1" >Odczyt</option>
                                <option value="2" selected="selected">Zapis</option>
                              @else
                                <option value="0" selected>BRAK</option>
                                <option value="1" >Odczyt</option>
                                <option value="2">Zapis</option>
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
          <a class ="devLink" href="{{ route('wnioski.addStep1') }}">WRÓĆ</a>
        </span>
    </fieldset>
    </div>
  </div>
@endsection