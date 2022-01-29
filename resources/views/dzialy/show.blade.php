@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
    @if (@isset($tab['tab']) && $tab['tab'] == 'u' )
      <legend>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=u"
        class="fieldsetLegendLink">
        Użytkownicy w dziale
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=u" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('UŻYTKOWNICY') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=komp" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('KOMPUTERY') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=dev" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('URZĄDZENIA') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=wn" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('WN') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      </table>
      <table class="devDet">
        @foreach($uzytkownicyDzialu as $uzytkownik)  
        <tr class="devDetRow">
          <td>
            @isset($uzytkownik->nazwa_u)
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}" class="devLink">  
                {{ $uzytkownik->nazwa_u }}
              </a>
            @endisset
          </td>
          <td>
            @isset($uzytkownik->imie_u)
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}" class="devLink">  
                {{ $uzytkownik->imie_u }}
              </a>
            @endisset
          </td>
          <td>
            @isset($uzytkownik->dns_k)
              <a href="{{ route('komputery.show', $uzytkownik->id_k) }}" class="devLink">  
                {{ $uzytkownik->dns_k }}
              </a>
            @endisset
          </td>
          <td>
            <form action="{{ route('dzialy.delUser', $dzial->id_dz) }}">
              @csrf
              <input type="hidden" name="id_u" value="{{ $uzytkownik->id_u }}">
              <input type="hidden" name="id_dz" value="{{ $uzytkownik->id_dz }}">
              <input type="hidden" name="tab" value="u">
              <button type="submit" class="redDelButton" onClick="return confirm('Ta operacja usunie użytkownika z działu !!!')"> 
            </form>
          </td>
        </tr>
        @endforeach
        <tr class="devDetRow">
        @isset($e['e']) 
        @if ($e['e'] == 'u')
          <td colspan="4">   
              <form action="{{ route('dzialy.addUser', $dzial->id_dz) }}">
              @csrf
              <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
              <input type="hidden" name="tab" value="u">
              @if (count($uToAdd)>0)
              <select name="id_u" id="idu" class="devDetSelect">
              @foreach($uToAdd as $uzytkownik)
                <option value="{{ $uzytkownik->id_u }}">
                  {{ $uzytkownik->nazwa_u }} {{ $uzytkownik->imie_u }}
                </option>
              @endforeach
              </select>
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span> 
              @else
                <span class="quickSubmit">
                  {{ __('Brak dostępnych kolejnych użytkowników') }}
                </span>
              @endif
            </form>
            </td>
            <td>
            @else
            <td>
            @if (count($uToAdd)>0)
            <form action="{{ route('dzialy.show', $dzial->id_dz) }}">
              @csrf
              <input type="hidden" name="id_dz" value="{{ $dzial->id_d }}">
              <input type="hidden" name="tab" value="u">
              <input type="hidden" name="e" value="u">
              <button type="submit" class="greenAddButton">
            </form>
            @endif
            </td>
            <td>
            @endif
          @endisset
          @empty($e)
          <td colspan="3"></td>
          <td>
              <form action="{{ route('dzialy.show', $dzial->id_dz) }}">
                @csrf
                <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
                <input type="hidden" name="tab" value="u">
                <input type="hidden" name="e" value="u">
                <button type="submit" class="greenAddButton">
              </form>
          </td>
          @endempty
          
        </tr>
      </table>
      @elseif (@isset($tab['tab']) && $tab['tab'] == 'wn' )
      <legend>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=wn"
        class="fieldsetLegendLink">
        Operatzorzy wniosków
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=u" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('UŻYTKOWNICY') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=komp" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('KOMPUTERY') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=dev" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('URZĄDZENIA') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=wn" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('WN') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      </table>
      <table class="devDet">
        @foreach($operatorzyWN as $operator)  
        <tr class="devDetRow">
          <td>
            @isset($operator->nazwa_u)
              <a href="{{ route('uzytkownicy.show', $operator->id_u) }}" class="devLink">  
                {{ $operator->nazwa_u }}
              </a>
            @endisset
          </td>
          <td>
            @isset($operator->imie_u)
              <a href="{{ route('uzytkownicy.show', $operator->id_u) }}" class="devLink">  
                {{ $operator->imie_u }}
              </a>
            @endisset
          </td>
          <td>
            @isset($operator->dns_k)
              <a href="{{ route('komputery.show', $operator->id_k) }}" class="devLink">  
                {{ $operator->dns_k }}
              </a>
            @endisset
          </td>
          <td>
            <form action="{{ route('dzialy.delOperatorWN', $dzial->id_dz) }}">
              @csrf
              <input type="hidden" name="id_u" value="{{ $operator->id_u }}">
              <input type="hidden" name="id_dz" value="{{ $operator->id_dz }}">
              <input type="hidden" name="id_wnu" value="{{ $operator->id_wnu }}">
              <input type="hidden" name="tab" value="wn">
              <button type="submit" class="redDelButton" onClick="return confirm('Ta operacja usunie użytkownika z działu !!!')"> 
            </form>
          </td>
        </tr>
        @endforeach
        <tr class="devDetRow">
        @isset($e['e']) 
        @if ($e['e'] == 'opwn')
          <td colspan="4">   
              <form action="{{ route('dzialy.addOperatorWN', $dzial->id_dz) }}">
              @csrf
              <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
              <input type="hidden" name="tab" value="u">
              @if (count($allUsers)>0)
              <select name="id_u" id="idu" class="devDetSelect">
              @foreach($allUsers as $uzytkownik)
                <option value="{{ $uzytkownik->id_u }}">
                  {{ $uzytkownik->nazwa_u }} {{ $uzytkownik->imie_u }}
                </option>
              @endforeach
              </select>
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span> 
              @else
                <span class="quickSubmit">
                  {{ __('Brak dostępnych kolejnych użytkowników') }}
                </span>
              @endif
            </form>
            </td>
            <td>
            @else
            <td>
            @if (count($allUsers)>0)
            <form action="{{ route('dzialy.show', $dzial->id_dz) }}">
              @csrf
              <input type="hidden" name="id_dz" value="{{ $dzial->id_d }}">
              <input type="hidden" name="tab" value="wn">
              <input type="hidden" name="e" value="opwn">
              <button type="submit" class="greenAddButton">
            </form>
            @endif
            </td>
            <td>
            @endif
          @endisset
          @empty($e)
          <td colspan="3"></td>
          <td>
              <form action="{{ route('dzialy.show', $dzial->id_dz) }}">
                @csrf
                <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
                <input type="hidden" name="tab" value="wn">
                <input type="hidden" name="e" value="opwn">
                <button type="submit" class="greenAddButton">
              </form>
          </td>
          @endempty
          
        </tr>
      </table>
      @elseif (@isset($tab['tab']) && $tab['tab'] == 'log' )
      <legend>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=u"
        class="fieldsetLegendLink">
        Historia zmian
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=u" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('UŻYTKOWNICY') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=komp" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('KOMPUTERY') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=dev" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('URZĄDZENIA') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=wn" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('WN') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=log" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDetLog">
        <tr class="devDetLogRow">
          <td class="devDetHead">Czas</td>
          <td class="devDetHead">Wpis</td>
          <td class="devDetHead">Kto</td>
        </tr>
        @foreach ($logiDzial as $log)
        <tr class="devDetRow">
          <td class="devDetLogData">{{ $log->created_at }}</td>
          <td class="devDetLogWpis">{{ $log->wpis }}</td>
          <td class="devDetLogKto">{{ $log->kto }}</td>
        </tr>
        @endforeach
      </table>
      {{ $logiDzial->links() }}

     
      @elseif (@isset($tab['tab']) && $tab['tab'] == 'komp' )
      <legend>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=komp"
        class="fieldsetLegendLink">
        Komputery Działu
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=u" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('UŻYTKOWNICY') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=komp" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('KOMPUTERY') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=dev" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('URZĄDZENIA') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=wn" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('WN') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      @isset ($komputeryDzialu)
        @foreach ($komputeryDzialu as $komp)
        <tr class="devDetRow">
            <td>
              <a href="{{ route('komputery.show', $komp->id_k) }}" class="devDetTabLink">
                {{ $komp->inwent_k }}
              </a>
            </td>
            <td>
              <a href="{{ route('komputery.show', $komp->id_k) }}" class="devDetTabLink">
                {{ $komp->dns_k }}
              </a>
            </td>
            <td>
              @isset($komp->id_u)
                <a href="{{ route('uzytkownicy.show', $komp->id_u) }}" class="devDetTabLink">
                  {{ $komp->nazwa_u }} {{ $komp->imie_u }}
                </a>
              @endisset
              <form action="{{ route('dzialy.delKomp', $dzial->id_dz) }}">
                @csrf
                <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
                <input type="hidden" name="id_k" value="{{ $komp->id_k }}">
                <input type="hidden" name="tab" value="komp">
                <input type="hidden" name="dnr" value="1">
                <button type="submit" class="redDelButton" onClick="return confirm('Ta operacja usunie komputer z działu !!!')">
              </form>
            </td>
          </tr>
          @endforeach
        @endisset
        @empty ($komputeryDzialu)
        <tr class="devDetRow">
          <td class="leftDevDetHead">{{ __('brak komputerów')}}</td>
          <td class="rightDevDetHead"></td>
        </tr>
        @endempty
        <tr class="devDetRow">
          <td colspan="4">
            @isset($e['e']) 
            <form action="{{ route('dzialy.addKomp', $dzial->id_dz) }}">
            @csrf
            <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
            <input type="hidden" name="tab" value="komp">
            @isset($kToAdd)
              @if(count($kToAdd)>0)
                <select name="id_k" id="komp" class="devDetSelect">
                @foreach($kToAdd as $komp)
                  <option value = "{{ $komp->id_k }}">{{ $komp->inwent_k }} {{ $komp->dns_k }}</option>
                @endforeach
                </select>
                <span class="quickSubmit">
                  <button type="submit" class="quickSubmitButton">
                    {{ __('OK') }}
                  </button>
                </span>
              </form>
              @else
              <span class="quickSubmit">
                  {{ __('Brak dostępnych komputerów') }}
              </span>
              @endif
            @endisset
            @endisset
            @empty($e)
            @if (count($kToAdd)>0)
            <form action="{{ route('dzialy.show', $dzial->id_dz) }}">
            @csrf
              <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
              <input type="hidden" name="tab" value="komp">
              <input type="hidden" name="e" value="id_k">
              <button type="submit" class="greenAddButton">
            </form>
            @endif
          @endempty
          </td>
          
        </tr>
      </table>

      @elseif (@isset($tab['tab']) && $tab['tab'] == 'dev' )
      <legend>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=u"
        class="fieldsetLegendLink">
        Dodatkowe urządzenia
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=u" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('UŻYTKOWNICY') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=komp" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('KOMPUTERY') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=dev" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('URZĄDZENIA') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=wn" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('WN') }}
          </span>
        </a>
        <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      @isset ($urzadzeniaDzialu)
        @foreach ($urzadzeniaDzialu as $dev)
        <tr class="devDetRow">
            <td>
              <a href="{{ route('urzadzenia.show', $dev->id_dev) }}" class="devDetTabLink">
                {{ $dev->inwent_dev }}
              </a>
            </td>
            <td>
              <a href="{{ route('urzadzenia.show', $dev->id_dev) }}" class="devDetTabLink">
                {{ $dev->nazwa_dev }}
              </a>
            </td>
            <td>
              <a href="{{ route('urzadzenia.show', $dev->id_dev) }}" class="devDetTabLink">
                {{ $dev->model_dev }}
              </a>
              <form action="{{ route('dzialy.delDev', $dzial->id_dz) }}">
                @csrf
                <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
                <input type="hidden" name="id_dev" value="{{ $dev->id_dev }}">
                <input type="hidden" name="tab" value="dev">
                <input type="hidden" name="dnr" value="1">
                <button type="submit" class="redDelButton" onClick="return confirm('Ta operacja usunie urządzenie z działu !!!')">
              </form>
            </td>
          </tr>
          @endforeach
        @endisset
        @empty ($devToAdd)
        <tr class="devDetRow">
          <td class="leftDevDetHead">{{ __('brak dostępnych dodatkowych urządzeń')}}</td>
          <td class="rightDevDetHead"></td>
        </tr>
        @endempty
        <tr class="devDetRow">
          <td colspan="4">
            @isset($e['e']) 
            <form action="{{ route('dzialy.addDev', $dzial->id_dz) }}">
            @csrf
            <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
            <input type="hidden" name="tab" value="dev">
            @isset($devToAdd)
              @if(count($devToAdd)>0)
                <select name="id_dev" id="dev" class="devDetSelect">
                @foreach($devToAdd as $dev)
                  <option value = "{{ $dev->id_dev }}">{{ $dev->inwent_dev }} {{ $dev->nazwa_dev }}</option>
                @endforeach
                </select>
                <span class="quickSubmit">
                  <button type="submit" class="quickSubmitButton">
                    {{ __('OK') }}
                  </button>
                </span>
              </form>
              @else
              <span class="quickSubmit">
                  {{ __('Brak dostępnych dodatkowych urządzeń') }}
              </span>
              @endif
            @endisset
            @endisset
            @empty($e)
            @if (count($urzadzeniaDzialu)>0)
            <form action="{{ route('dzialy.show', $dzial->id_dz) }}">
            @csrf
              <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
              <input type="hidden" name="tab" value="dev">
              <input type="hidden" name="e" value="dev">
              <button type="submit" class="greenAddButton">
            </form>
            @endif
          @endempty
          </td>
        </tr>
      </table>
      @else
        <legend>
          <a href="{{ route('dzialy.show', $dzial->id_dz) }}"
            class="fieldsetLegendLink">
            Szczegóły Działu
          </a>
        </legend>
        <span class="devDetTabWrapper">
          <a href="{{ route('dzialy.show', $dzial->id_dz) }}" class="devDetTabLink">
            <span class="devDetActiveTab">
              {{ __('DANE') }}
            </span>
          </a>
          <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=u" class="devDetTabLink">
            <span class="devDetTab">
              {{ __('UŻYTKOWNICY') }}
            </span>
          </a>
          <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=komp" class="devDetTabLink">
            <span class="devDetTab">
              {{ __('KOMPUTERY') }}
            </span>
          </a>
          <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=dev" class="devDetTabLink">
            <span class="devDetTab">
              {{ __('URZĄDZENIA') }}
            </span>
          </a>
          <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=wn" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('WN') }}
          </span>
        </a>
          <a href="{{ route('dzialy.show', $dzial->id_dz) }}?tab=log" class="devDetTabLink">
            <span class="devDetTab">
              {{ __('LOG') }}
            </span>
          </a>
        </span>
        <table class="devDet">
          @isset($e)
            <form action="/dzialy/updateOneCol/{{ $dzial->id_dz }}">
              @csrf
              <input type="hidden" name="id_dz" value ="{{ $dzial->id_dz }}"> 
          @endisset
          <tr class="devDetRow">
            <td class="leftDevDetHead">Symbol Działu</td>
            <td>
              @isset($e['e'])
                @if ($e['e'] == 'symbol_d')
                <input id="Nazwa" type="text" class="devDetField" name="symbol_d" value="{{ $dzial->symbol_d }}" 
                    required autofocus>
                <input type="hidden" name="oldProperty" value="symbol_d">
                  @if ($dzial->symbol_d != NULL)
                    <input type="hidden" name="old_symbol_d" value ="{{ $dzial->symbol_d }}">
                  @endif
                  @error('symbol_d')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                @else
                  <a href="{{ route('dzialy.show', $dzial->id_dz) }}?e=symbol_d" class="devLink">
                    {{ $dzial->symbol_d }}
                  </a>
                @endif
              @endisset
              @empty ($e)
              <a href="{{ route('dzialy.show', $dzial->id_dz) }}?e=symbol_d" class="devLink">
                {{ $dzial->symbol_d }}
              </a>
              @endempty  
            </td>
          </tr>
          <tr class="devDetRow">
            <td class="leftDevDetHead">Nazwa Działu</td>
            <td>
              @isset($e['e'])
                @if ($e['e'] == 'nazwa_d')
                <input id="Nazwa" type="text" class="devDetField" name="nazwa_d" value="{{ $dzial->nazwa_d }}" 
                    required autofocus>
                <input type="hidden" name="oldProperty" value="nazwa_d">
                  @if ($dzial->nazwa_d != NULL)
                    <input type="hidden" name="old_nazwa_d" value ="{{ $dzial->nazwa_d }}">
                  @endif
                  @error('nazwa_d')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                @else
                  <a href="{{ route('dzialy.show', $dzial->id_dz) }}?e=nazwa_d" class="devLink">
                    {{ $dzial->nazwa_d }}
                  </a>
                @endif
              @endisset
              @empty ($e)
              <a href="{{ route('dzialy.show', $dzial->id_dz) }}?e=nazwa_d" class="devLink">
                {{ $dzial->nazwa_d }}
              </a>
              @endempty  
            </td>
          </tr>
          <tr class="devDetRow">
            <td class="leftDevDetHead">Pion Działu</td>
            <td>
            @isset($e['e'])
              @if ($e['e'] == 'id_p')
                <div class="newDevice">
                  <select name="id_p" id="pion" class="devDetSelect">
                  @foreach($piony as $pion)
                    @if ($dzial->id_p == $pion->id_p)
                      <option value = "{{ $pion->id_p }}" selected>{{ $pion->nazwa_p }}</option>
                    @else
                      <option value = "{{ $pion->id_p }}">{{ $pion->nazwa_p }}</option>
                    @endif
                  @endforeach
                  </select>
                  <input type="hidden" name="oldProperty" value="id_p">
                  @if ($dzial->id_p != NULL)
                    <input type="hidden" name="old_id_p" value ="{{ $dzial->id_p }}">
                  @endif
                  <span class="quickSubmit">
                    <button type="submit" class="quickSubmitButton">
                      {{ __('OK') }}
                    </button>
                  </span>
                </div>
              @else
                <a href="{{ route('dzialy.show', $dzial->id_dz) }}?e=id_p" class="devLink">
                  {{ $dzial->nazwa_p }}
                </a>
              @endif
            @endisset
          @empty($e)
            <a href="{{ route('dzialy.show', $dzial->id_dz) }}?e=id_p" class="devLink">
              {{ $dzial->nazwa_p }}
            </a>
          @endempty  
            </td>
          </tr>

          <tr class="devDetRow">
            <td class="leftDevDetHead">Dział Nadrzędny</td>
            <td>
              @isset($e['e'])
                @if ($e['e'] == 'parent_dz')
                  <div class="newDevice">
                    <select name="parent_dz" id="parent" class="devDetSelect">
                    @if ($dzial->parent_dz > 0)
                      <option value = "{{ $dzial->id_dz }}" selected>{{ __('ODŁĄCZ') }}</option>
                    @endif
                    @foreach($parentDzialy as $parentDzial)
                      <option value = "{{ $parentDzial->id_dz }}">{{ $parentDzial->symbol_d }}</option>
                    @endforeach
                    </select>
                    <input type="hidden" name="oldProperty" value="parent_dz">
                    @if ($dzial->parent_dz != NULL && $dzial->parent_dz > 0 )
                      <input type="hidden" name="old_parent_dz" value ="{{ $dzial->parent_dz }}">
                    @endif
                    <span class="quickSubmit">
                      <button type="submit" class="quickSubmitButton">
                        {{ __('OK') }}
                      </button>
                    </span>
                  </div>
                @else
                  <a href="{{ route('dzialy.show', $dzial->id_dz) }}?e=parent_dz" class="devLink">
                  @if($dzial->parentSymbolD)
                    {{ $dzial->parentSymbolD }}
                  @else
                    <span class="greenAddButton"></a>
                  @endif
                  </a>
                @endif
              @endisset
              @empty($e)
                <a href="{{ route('dzialy.show', $dzial->id_dz) }}?e=parent_dz" class="devLink">
                @if($dzial->parentSymbolD)
                  {{ $dzial->parentSymbolD }}
                @else
                  <span class="greenAddButton"></a>
                @endif
                </a>
              @endempty  
            </td>
          </tr>
          <tr class="devDetRow">
            <td class="leftDevDetHead">Kierownik</td>
            <td>
              @isset($e['e'])
                @if ($e['e'] == 'id_uk')
                  <div class="newDevice">
                    <select name="id_uk" id="parent" class="devDetSelect">
                    @if ($dzial->id_uk > 0)
                      <option value = "{{ $dzial->id_uk }}" selected>{{ __('ODŁĄCZ ') }}</option>
                    @endif
                    @foreach($ukToAdd as $uzytkownik)
                      <option value = "{{ $uzytkownik->id_u }}">{{ $uzytkownik->nazwa_u }} {{ $uzytkownik->imie_u }}</option>
                    @endforeach
                    </select>
                    <input type="hidden" name="oldProperty" value="id_uk">
                    @if ($dzial->id_uk != NULL && $dzial->id_uk > 0)
                      <input type="hidden" name="old_id_uk" value ="{{ $dzial->id_uk }}">
                    @endif
                    <span class="quickSubmit">
                      <button type="submit" class="quickSubmitButton">
                        {{ __('OK') }}
                      </button>
                    </span>
                    @error('id_uk')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                @else
                  <a href="{{ route('dzialy.show', $dzial->id_dz) }}?e=id_uk" class="devLink">
                  @if($dzial->nazwa_u && $dzial->imie_u)
                    {{ $dzial->nazwa_u }} {{ $dzial->imie_u }}
                  @else
                    <span class="greenAddButton"></a>
                  @endif
                  </a>
                @endif
              </form>
              @endisset
              @empty($e)
                <a href="{{ route('dzialy.show', $dzial->id_dz) }}?e=id_uk" class="devLink">
                @if($dzial->nazwa_u && $dzial->imie_u)
                    {{ $dzial->nazwa_u }} {{ $dzial->imie_u }}
                  @else
                  <span class="greenAddButton"></a>
                @endif
                </a>
              @endempty  
            </td>
          </tr> 
        </table>
      @endif
      @isset($dzial)
        @if($dzial->status_dz == 0)
        <span class="editButton">
            <form action="{{ route('dzialy.show', $dzial->id_dz) }}" method="POST">
                @csrf
                <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
                @method('DELETE')
                <button class="devButtonRed" onClick="return confirm('Ta operacja usunie całkowicie dział !!!')">
                    USUŃ
                </button>
            </form>
        </span>
        <span class="editButton">
            <form action="{{ route('dzialy.activate', $dzial->id_dz) }}" method="POST">
                @csrf
                <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
                <button class="devButton" onClick="return confirm(Ta operacja przywróci dział !!!)">
                    PRZYWRÓĆ
                </button>
            </form>
        </span>
        @else
          <span class="editButton">
            <form action="{{ route('dzialy.disable',$dzial->id_dz) }}" method="POST">
                @csrf
                <input type="hidden" name="id_dz" value="{{ $dzial->id_dz }}">
                <button class="devButtonRed" onClick="return confirm('Ta operacja oznaczy dział jako usunięty!!!')">
                    USUŃ
                </button>
            </form>
          </span>
        @endif
      @endisset
      @if($dzial->status_dz == 0)
        <span class="editButton"> 
        <a href="/dzialy/?active=0" class="devLink">WRÓĆ</a>
        </span>
      @else
        <span class="editButton"> 
        <a href="/dzialy" class="devLink">WRÓĆ</a>
        </span>
      @endif
    </fieldset>
  </div>
</div>
@endsection