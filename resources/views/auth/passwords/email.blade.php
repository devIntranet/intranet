@extends('layouts.layout')

@section('content')
<div id="TRESC">
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <fieldset class="authFieldset">
    <legend>Resetowanie hasła</legend>
    <div class="email">
        <div class="email">
            <label for="email" class="email">{{ __('e-mail') }}</label>
        </div>
        <div class="email">
        <input id="email" type="email" class="authField @error('email') is-invalid @enderror" name="email" 
            value="{{ old('email') }}" required autocomplete="email" 
            pattern="+@rpwik.tychy.pl" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
    </div>
    <span class="authButton">
        <button type="submit" class="authButton">
            {{ __('Wyślij') }}
        </button>
    </span>
    <span class="forgottenPassword">
        <a class="forgottenPassword" href="{{ route('login') }}">
            {{ __('Wróć do logowania') }}
        </a>
    </span>
    </fieldset>
</form>
</div>
@endsection
