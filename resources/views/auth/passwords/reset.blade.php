@extends('layouts.layout')

@section('content')
<div id="TRESC">
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <fieldset class="authFieldset">
        <legend>Reset hasła</legend>
    <div class="authRowDiv">
        <div class="loginlabel">
            <label for="email" class="email">{{ __('Login') }}</label>
        </div>
        <div class="email">
            <input id="email" type="text" 
                class="authField @error('email') is-invalid @enderror" 
                name="email" 
                value="{{ $email ?? old('email') }}" 
                required autocomplete="email" 
                autofocus
                pattern="+@rpwik.tychy.pl"
            >
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="authRowDiv">
        <div class="loginlabel">
            <label for="password" class="password">{{ __('Hasło') }}</label>
        </div>
        <div class="password">   
            <input id="password" type="password" class="authField" name="password" size="50" required autocomplete="current-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    
    <div class="authRowDiv">
        <div class="passwordlabel">
            <label for="password" class="password">{{ __('Potwierdź hasło') }}</label>
        </div>
         <div class="password-confirm">   
            <input id="password-confirm" 
                type="password" 
                class="authField" 
                name="password_confirmation" 
                size="50" 
                required 
                autocomplete="current-password"
            >
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <span class="reset">
        <button type="submit" class="authButton">
            {{ __('Resetowanie') }}
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