@extends('layouts.layout')

@section('content')
<div id="TRESC">
<form method="POST" action="{{ route('login') }}">
    @csrf
    <fieldset class="authFieldset">
        <legend>Logowanie</legend>
   
    @if (session('status'))
        <div class="loginmessage">
            {{ session('status') }}
        </div>
    @endif
    <div class="authRowDiv">
        <div class="loginlabel">
            <label for="username" class="username">{{ __('Login') }}</label>
        </div>
        <div class="username">
            <input id="username" type="text" class="authField" name="username" value="{{ old('username') }}" 
            required autofocus>
            @error('username')
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
    
    <span class="authRowSpan">
        <button type="submit" class="authButton">
            {{ __('Logowanie') }}
        </button>
    </span>    
    @if (Route::has('password.request'))
    <span class="authRowSpan">
        <a class="forgottenPassword" href="{{ route('password.request') }}">
            {{ __('Nie pamiętam hasła') }}
        </a>
    </span>
    @endif
    </fieldset>
</form>
</div>
    
          

@endsection
