@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      @if (@isset($tab['tab']) && $tab['tab'] == 'log' )
      <legend>
        <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u, ['tab' => 'log']) }}" class="fieldsetLegendLink">
        Historia zmian
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?tab=log" class="devDetTabLink">
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
        @foreach ($logiUzytkownik as $log)
        <tr class="devDetRow">
          <td class="devDetLogData">{{ $log->created_at }}</td>
          <td class="devDetLogWpis">{{ $log->wpis }}</td>
          <td class="devDetLogKto">{{ $log->kto }}</td>
        </tr>
        @endforeach
      </table>
      {{ $logiUzytkownik->links() }}
      
      @else
      <legend>
        <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}"
          class="fieldsetLegendLink">
          Szczegóły użytkownika
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      @isset($e['e'])
        <form action="{{ route('uzytkownicy.updateOneCol', $uzytkownik->id_u) }}">
        @csrf
        <input type="hidden" name="id_u" value ="{{ $uzytkownik->id_u }}"> 
      @endisset
       <tr class="devDetRow">
          <td class="leftDevDetHead">Nazwisko</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'nazwa_u')
              <input id="Nazwa" type="text" class="devDetField" name="nazwa_u" value="{{ $uzytkownik->nazwa_u }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="nazwa_u">
              @if ($uzytkownik->nazwa_u != NULL)
                <input type="hidden" name="old_nazwa_u" value ="{{ $uzytkownik->nazwa_u }}">
              @endif
                 @error('nazwa_u')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
                <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?e=nazwa_u" class="devLink">
                @if ($uzytkownik->nazwa_u)
                  {{ $uzytkownik->nazwa_u }}
                @else
                  <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?e=nazwa_u" class="devLink">
              @if ($uzytkownik->nazwa_u)
                {{ $uzytkownik->nazwa_u }}
              @else
                <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Imię</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'imie_u')
              <input id="imie" type="text" class="devDetField" name="imie_u" value="{{ $uzytkownik->imie_u }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="imie_u">
              @if ($uzytkownik->imie_u != NULL)
                <input type="hidden" name="old_imie_u" value ="{{ $uzytkownik->imie_u }}">
              @endif
                 @error('imie_u')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
                <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u )}}?e=imie_u" class="devLink">
                @if ($uzytkownik->imie_u)
                  {{ $uzytkownik->imie_u }}
                @else
                  <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u )}}?e=imie_u" class="devLink">
              @if ($uzytkownik->imie_u)
                {{ $uzytkownik->imie_u }}
              @else
                <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <td class="leftDevDetHead">Login AD</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'loginad_u')
              <input id="imie" type="text" class="devDetField" name="loginad_u" value="{{ $uzytkownik->loginad_u }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="loginad_u">
              @if ($uzytkownik->loginad_u != NULL)
                <input type="hidden" name="old_loginad_u" value ="{{ $uzytkownik->loginad_u }}">
              @endif
                 @error('loginad_u')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
                <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u )}}?e=loginad_u" class="devLink">
                @if ($uzytkownik->loginad_u)
                  {{ $uzytkownik->loginad_u }}
                @else
                  <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u )}}?e=loginad_u" class="devLink">
              @if ($uzytkownik->loginad_u)
                {{ $uzytkownik->loginad_u }}
              @else
                <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Dział</td>
          <td>
          @isset($e['e'])
            @if ($e['e'] == 'id_dz')
            <div class="newDevice">
            <select name="id_dz" id="dzial" class="devDetSelect">
            @foreach($dzialy as $dzial)
                @if ($uzytkownik->id_dz != $dzial->id_dz)
                  <option value = "{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_dz">
            @if ($uzytkownik->id_dz != NULL)
                <input type="hidden" name="old_id_dz" value ="{{ $uzytkownik->id_dz }}">
            @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
              @isset($uzytkownik->id_dz)  
                @isset($uzytkownik->id_k)
                  @if($uzytkownik->id_dz > 0 && $uzytkownik->id_kompIdDz > 0 && $uzytkownik->id_dz != $uzytkownik->id_kompIdDz)
                    <span class="inconsist">
                      <a href="{{ route('dzialy.show',  $uzytkownik->id_dz) }}" class="devLink">{{ $uzytkownik->symbol_d }}</a>
                    </span>
                  @else
                    <a href="{{ route('dzialy.show',  $uzytkownik->id_dz) }}" class="devLink">{{ $uzytkownik->symbol_d }}</a>
                  @endif
                @else
                  <a href="{{ route('dzialy.show',  $uzytkownik->id_dz) }}" class="devLink">{{ $uzytkownik->symbol_d }}</a>
                @endisset
                <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?e=id_dz" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @else
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?e=id_dz" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @endisset
            @endif
          @endisset
          @empty($e)
            @isset($uzytkownik->id_dz)
              @isset($uzytkownik->id_k)
                @if($uzytkownik->id_dz > 0 && $uzytkownik->id_kompIdDz > 0 && $uzytkownik->id_dz != $uzytkownik->id_kompIdDz)
                  <span class="inconsist">
                    <a href="{{ route('dzialy.show',  $uzytkownik->id_dz) }}" class="devLink">{{ $uzytkownik->symbol_d }}</a>
                  </span>
                @else
                  <a href="{{ route('dzialy.show',  $uzytkownik->id_dz) }}" class="devLink">{{ $uzytkownik->symbol_d }}</a>
                @endif
                @else
                  <a href="{{ route('dzialy.show',  $uzytkownik->id_dz) }}" class="devLink">{{ $uzytkownik->symbol_d }}</a>
                @endisset
                <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?e=id_dz" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @else
                <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?e=id_dz" class="devLink">  
                  <span class="greenAddButton">
                </a>
              @endisset
          @endempty
          </td>
        </tr>

        <tr class="devDetRow">
          <td class="leftDevDetHead">Komputer</td>
          <td>
          @isset($e['e'])
            @if ($e['e'] == 'id_k')
            <div class="newDevice">
            <select name="id_k" id="komp" class="devDetSelect">
            @if ($uzytkownik->id_k)  
              <option value = "{{ $uzytkownik->id_k }}" selected>{{ __('USUŃ') }}</option>  
            @endif  
            @foreach($komputery as $komp)
                @if ($uzytkownik->id_k != $komp->id_k)
                  <option value = "{{ $komp->id_k }}">{{ $komp->dns_k }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_k">
            @if ($uzytkownik->id_k != NULL)
                <input type="hidden" name="old_id_k" value ="{{ $uzytkownik->id_k }}">
              @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
            @isset($uzytkownik->id_k)  
              @isset($uzytkownik->id_dz)
                @if($uzytkownik->id_dz > 0 && $uzytkownik->id_kompIdDz > 0 && $uzytkownik->id_dz != $uzytkownik->id_kompIdDz)
                  <span class="inconsist">
                    <a href="{{ route('komputery.show',  $uzytkownik->id_k) }}" class="devLink">{{ $uzytkownik->dns_k }}</a>
                  </span>
                @else
                  <a href="{{ route('komputery.show',  $uzytkownik->id_k) }}" class="devLink">{{ $uzytkownik->dns_k }}</a>
                @endif
              @else
                <a href="{{ route('komputery.show',  $uzytkownik->id_k) }}" class="devLink">{{ $uzytkownik->dns_k }}</a>
              @endisset
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?e=id_k" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @else
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?e=id_k" class="devLink">  
                <span class="greenAddButton">
              </a>
            @endisset
          @endif
        @endisset
        @empty($e)
          @isset($uzytkownik->id_k)
            @isset($uzytkownik->id_dz)
              @if($uzytkownik->id_dz > 0 && $uzytkownik->id_kompIdDz > 0 && $uzytkownik->id_dz != $uzytkownik->id_kompIdDz)
                <span class="inconsist">
                  <a href="{{ route('komputery.show',  $uzytkownik->id_k) }}" class="devLink">{{ $uzytkownik->dns_k}}</a>
                </span>
              @else
                <a href="{{ route('komputery.show',  $uzytkownik->id_k) }}" class="devLink">{{ $uzytkownik->dns_k }}</a>
              @endif
            @else
                <a href="{{ route('komputery.show',  $uzytkownik->id_k) }}" class="devLink">{{ $uzytkownik->dns_k }}</a>
            @endisset
            <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?e=id_k" class="devLink">  
              <img class="changeIcon" src="/img/change.png">
            </a>
            @else
            <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}?e=id_k" class="devLink">  
                <span class="greenAddButton">
              </a>
            @endisset
          @endempty
          </td>
        </tr>
      </table>
      @isset($e)
        </form>
      @endisset
   @isset($uzytkownik)
    @if($uzytkownik->status_u == 0)
    <span class="editButton">
      <form action="{{ route('uzytkownicy.disable', $uzytkownik->id_u) }}" method="POST">
        @csrf
        <input type="hidden" name="id_u" value="{{ $uzytkownik->id_u }}">
        @method('DELETE')
        <button class="devButtonRed" onClick="return confirm('Ta operacja usunie całkowicie uzytkownik !!!')">
          USUŃ
        </button>
      </form>
    </span>
    <span class="editButton">
      <form action="{{ route('uzytkownicy.activate', $uzytkownik->id_u) }}" method="POST">
        @csrf
        <input type="hidden" name="id_u" value="{{ $uzytkownik->id_u }}">
        <button class="devButton" onClick="return confirm(Ta operacja przywróci uzytkownika !!!)">
          PRZYWRÓĆ
        </button>
      </form>
    </span>
    @else
    <span class="editButton">
      <form action="{{route('uzytkownicy.disable', $uzytkownik->id_u) }}" method="POST">
        @csrf
        <input type="hidden" name="id_u" value="{{ $uzytkownik->id_u }}">
        <button class="devButtonRed" onClick="return confirm('Ta operacja oznaczy uzytkownika jako usuniętego!!!')">
          USUŃ
        </button>
      </form>
    </span>
    @endif
  @endisset
@if($uzytkownik->status_u == 0)
<span class="editButton"> 
  <a href="/uzytkownicy/?active=0" class="devLink">WRÓĆ</a>
</span>
@else
<span class="editButton"> 
  <a href="/uzytkownicy" class="devLink">WRÓĆ</a>
</span>
@endif
@endif
  </fieldset>  
</div>
</div>
@endsection