@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      @if (@isset($tab['tab']) && $tab['tab'] == 'inst' )
      <legend>
        <a href="{{route( 'programy.show', $program->id_p) }}"
        class="fieldsetLegendLink">
        Instalacje Programu
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="{{route( 'programy.show', $program->id_p) }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="{{route( 'programy.show', $program->id_p) }}?tab=inst" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('INSTALACJE') }}
          </span>
        </a>
        <a href="{{route( 'programy.show', $program->id_p) }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
        <tr class="devDetLogRow">
          <td class="devDetHead">Komputer</td>
          <td class="devDetHead">Dział</td>
          <td class="devDetHead">Użytkownik</td>
          <td class="devDetHead">Data</td>
        </tr>
        @foreach($installed as $instalacja)
          <tr class="devBodyTR">      
            <td class="devBodyTD">
              @if(isset($instalacja->id_k))
                <a href="{{ route('komputery.show', $instalacja->id_k) }}" class="devLink">
                  <div class="devBodyCell">
                    {{ $instalacja->dns_k }}
                  </div>
                </a>
              @endif
            </td>
            <td class="devBodyTD">
              @if(isset($instalacja->id_dz))
                <a href="{{ route('dzialy.show', $instalacja->id_dz) }}" class="devLink">
                  <div class="devBodyCell">
                    {{ $instalacja->symbol_d }}
                  </div>
                </a>
              @endif
            </td>
            <td class="devBodyTD">
              @if(isset($instalacja->id_u))
                <a href="{{ route('uzytkownicy.index', $instalacja->id_u) }}" class="devLink">
                  <div class="devBodyCell">
                    {{ $instalacja->nazwa_u }} {{ $instalacja->imie_u }}
                  </div>
                </a>
              @endif
            </td>
            <td class="devBodyTD">
              <div class="devBodyCell">
                {{ $instalacja->updated_at }}
              </div>
            </td>
          </tr>
        @endforeach
      </table>


      @elseif (@isset($tab['tab']) && $tab['tab'] == 'log' )
      <legend>
        <a href="{{route( 'programy.show', $program->id_p) }}?tab=log"
        class="fieldsetLegendLink">
        Historia zmian
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="{{route( 'programy.show', $program->id_p) }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="{{route( 'programy.show', $program->id_p) }}?tab=inst" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('INSTALACJE') }}
          </span>
        </a>
        <a href="{{route( 'programy.show', $program->id_p) }}?tab=log" class="devDetTabLink">
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
        @foreach ($logiSoft as $log)
        <tr class="devDetRow">
          <td class="devDetLogData">{{ $log->created_at }}</td>
          <td class="devDetLogWpis">{{ $log->wpis }}</td>
          <td class="devDetLogKto">{{ $log->kto }}</td>
        </tr>
        @endforeach
      </table>
      {{ $logiSoft->links() }}
      
      @else
      <legend>
        <a href="{{route( 'programy.show', $program->id_p) }}"
          class="fieldsetLegendLink">
          Szczegóły programu
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="{{route( 'programy.show', $program->id_p) }}" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="{{route( 'programy.show', $program->id_p) }}?tab=inst" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('INSTALACJE') }}
          </span>
        </a>
        <a href="{{route( 'programy.show', $program->id_p) }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      @isset($e)
        <form action="{{route( 'programy.updateOneCol', $program->id_p) }}">
        @csrf
        <input type="hidden" name="id_p" value ="{{ $program->id_p }}"> 
       @endisset
        <tr class="devDetRow">
          <td class="leftDevDetHead">Nazwa Programu</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'nazwa')
              <input id="Nazwa" type="text" class="devDetField" name="nazwa_p" value="{{ $program->nazwa_p }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="nazwa_p">
              @if ($program->nazwa_p != NULL)
                <input type="hidden" name="old_nazwa_p" value ="{{ $program->nazwa_p }}">
              @endif
                 @error('nazwa_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
                <a href="{{route( 'programy.show', $program->id_p) }}?e=nazwa" class="devLink">{{ $program->nazwa_p }}</a>
              @endif
            @endisset
            @empty ($e)
              <a href="{{route( 'programy.show', $program->id_p) }}?e=nazwa" class="devLink">{{ $program->nazwa_p }}</a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Typ Programu</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'typ')
              <select name="typ_p" class="devDetField">
                <option value="1">{{ __('System Operacyjny') }}
                <option value="2">{{ __('Program użytkowy') }}
              </select>
              <input type="hidden" name="oldProperty" value="typ_p">
              @if ($program->typ_p != NULL)
                <input type="hidden" name="old_typ_p" value ="{{ $program->typ_p }}">
              @endif
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span>
                  @error('typ_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="{{ route('programy.show', $program->id_p) }}?e=typ" class="devLink">  
                @if ($program->typ_p)
                  @if ($program->typ_p == 1)    
                    {{ __('System Operacyjny') }}
                  @else
                    {{ __('Program użytkowy') }}
                  @endif
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="{{ route('programy.show', $program->id_p) }}?e=typ" class="devLink">  
                @if ($program->typ_p)
                  @if ($program->typ_p == 1)    
                    {{ __('System Operacyjny') }}
                  @else
                    {{ __('Program użytkowy') }}
                  @endif
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Typ licencji</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'lic')
              <input id="Licencja" type="text" class="devDetField" name="lic_p" value="{{ $program->lic_p }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="lic_p">
              @if ($program->lic_p != NULL)
                <input type="hidden" name="old_lic_p" value ="{{ $program->lic_p }}">
              @endif
                  @error('lic_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="{{ route('programy.show', $program->id_p) }}?e=lic" class="devLink">  
                @if ($program->lic_p)
                    {{ $program->lic_p }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="{{ route('programy.show', $program->id_p) }}?e=lic" class="devLink">  
                @if ($program->lic_p)
                  {{ $program->lic_p }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Liczba licencji</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'licqty')
              <input id="Licencja" type="text" class="devDetField" name="licqty_p" value="{{ $program->licqty_p }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="licqty_p">
              @if ($program->licqty_p != NULL)
                <input type="hidden" name="old_licqty_p" value ="{{ $program->licqty_p }}">
              @endif
                  @error('licqty_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="{{ route('programy.show', $program->id_p) }}?e=licqty" class="devLink">  
                @if ($program->licqty_p)
                    {{ $program->licqty_p }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="{{ route('programy.show', $program->id_p) }}?e=licqty" class="devLink">  
                @if ($program->licqty_p)
                  {{ $program->licqty_p }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Data zakupu</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'data')
              <input type="date" name="data_p" id="data" class="devDetField" value="{{ $program->data_p }}">
              @error('data_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              <input type="hidden" name="oldProperty" value="data_p">
              @if ($program->data_p != NULL)
                <input type="hidden" name="old_data_p" value ="{{ $program->data_p }}">
              @endif
                <span class="quickSubmit">
                  <button type="submit" class="quickSubmitButton">
                    {{ __('OK') }}
                  </button>
                </span> 
              @else
                <a href="/programy/{{ $program->id_p }}?e=data" class="devLink">  
                @if ($program->data_p)
                    {{ $program->data_p }}
                @else
                    <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/programy/{{ $program->id_p }}?e=data" class="devLink">  
              @if ($program->data_p)
                  {{ $program->data_p }}
              @else
                  <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td>
        </tr>
        
        <tr class="devDetRow">
          <td class="leftDevDetHead">liczba instalacji</td>
          <td>
            {{ $install}}  
          </td>
        </tr>
      </table>
      @isset($e)
        </form>
      @endisset
   @isset($program)
    @if($program->status_p == 0)
    <span class="editButton">
      <form action="{{ route('programy.disable', $program->id_p) }}" method="POST">
        @csrf
        <input type="hidden" name="id_p" value="{{ $program->id_p }}">
        @method('DELETE')
        <button class="devButtonRed" onClick="return confirm('Ta operacja usunie całkowicie program !!!')">
          USUŃ
        </button>
      </form>
    </span>
    <span class="editButton">
      <form action="{{ route('programy.activate', $program->id_p) }}" method="POST">
        @csrf
        <input type="hidden" name="id_p" value="{{ $program->id_p }}">
        <button class="devButton" onClick="return confirm(Ta operacja przywróci program !!!)">
          PRZYWRÓĆ
        </button>
      </form>
    </span>
    @else
    <span class="editButton">
      <form action="{{ route('programy.disable', $program->id_p) }}" method="POST">
        @csrf
        <input type="hidden" name="id_p" value="{{ $program->id_p }}">
        <button class="devButtonRed" onClick="return confirm('Ta operacja oznaczy program jako usunięty!!!')">
          USUŃ
        </button>
      </form>
    </span>
    @endif
  @endisset
@if($program->status_p == 0)
<span class="editButton"> 
  <a href="/programy/?active=0" class="devLink">WRÓĆ</a>
</span>
@else
<span class="editButton"> 
  <a href="/programy" class="devLink">WRÓĆ</a>
</span>
@endif
@endif
  </fieldset>  
</div>
</div>
@endsection