@component('mail::message')
# Wiadomiość testowa systamu mailowania

Treść wiadomości

@component('mail::button', ['url' => ''])
Przycisk
@endcomponent

Dzięki,<br>
{{ config('app.name') }}
@endcomponent
