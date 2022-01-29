<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute musi być akceptowany.',
    'active_url' => ':attribute nie jest prawidłowym adresem URL.',
    'after' => ':attribute musi być datą późniejszą niż :date.',
    'after_or_equal' => ':attribute musi być datą równą lub późniejszą niż:date.',
    'alpha' => ':attribute może zawierać jedynie litery.',
    'alpha_dash' => ':attribute może zawierać jedynie litery, cyfry, myślniki i podkreślniki.',
    'alpha_num' => ':attribute może zawierać jedynie litery i cyfry.',
    'array' => ':attribute musi być tablicą.',
    'before' => ':attribute musi być datą poprzedzającą :date.',
    'before_or_equal' => ':attribute musi być datą wcześniejszą lub równą :date.',
    'between' => [
        'numeric' => 'Liczba :attribute musi zawierać się między :min a :max.',
        'file' => 'Plik :attribute musi mieć rozmiar niemniejży niż :min Kb i niewiększy niż :max Kb.',
        'string' => 'Ciąg :attribute musi posiadać minimin :min i maksimum :max znaków.',
        'array' => 'Tablica :attribute musi zawierać co najmniej :min elementów i nie więcej niż :max.',
    ],
    'boolean' => ':attribute pole musi być typy prawda/fałsz',
    'confirmed' => 'potwierdzenie :attribute jest niezgodne ze wzorcem.',
    'date' => ':attribute nie jest poprawną formą daty.',
    'date_equals' => ':attribute musi być równy :date.',
    'date_format' => ':attribute nie jest zgodny z formatem :format.',
    'different' => ':attribute oraz :other muszą być różne.',
    'digits' => ':attribute musi zawierać :digits cyfr.',
    'digits_between' => ':attribute musi zawierać co najmniej :min i nie więcej niż :max cyfr.',
    'dimensions' => ':attribute posiada nieprawidłowe wymiary obrazu.',
    'distinct' => ':attribute pole zawiera zduplikowane dane.',
    'email' => ':attribute musi być poprawnym adresem e-mail.',
    'ends_with' => ':attribute musi się kończyć następującą wartością: :values.',
    'exists' => 'Wybrany :attribute jest nieprawidłowy.',
    'file' => ':attribute musi być plikiem.',
    'filled' => 'Pole :attribute musi być prawidłowo wypełnione.',
    'gt' => [
        'numeric' => 'Liczba :attribute musi być większa niż :value.',
        'file' => 'Plik :attribute musi być większy niż :value kb.',
        'string' => 'Ciąg :attribute musi być dłuższy niż :value znaków.',
        'array' => 'Tablica :attribute musi zawierać więcej niż :value elementów.',
    ],
    'gte' => [
        'numeric' => 'Liczba :attribute musi być większa lub równa :value.',
        'file' => 'Plik :attribute musi być większy lub równy :value kb.',
        'string' => 'Ciąg :attribute musi zawierać co najmniej :value znaków.',
        'array' => 'Tablica :attribute musi zawierać co najmniej :value elementów.',
    ],
    'image' => ':attribute musi być obrazem.',
    'in' => 'Wybrany :attribute jest niepoprawny.',
    'in_array' => 'Pole :attribute nie istnieje w :other.',
    'integer' => ':attribute musi być liczbą całkowitą.',
    'ip' => ':attribute musi być poprawnym adresem IP.',
    'ipv4' => ':attribute musi być poprawnym adresem IPv4.',
    'ipv6' => ':attribute musi być poprawnym adresem IPv6.',
    'json' => ':attribute musi być poprawnym ciągiem JSON.',
    'lt' => [
        'numeric' => 'Liczba :attribute musi być mniejsza niż :value.',
        'file' => 'Plik :attribute musi być mniejszy niż :value kb.',
        'string' => 'Ciąg :attribute musi być krótszy niż :value znaków.',
        'array' => 'Tablica :attribute musi mieć mnież niż :value elementów.',
    ],
    'lte' => [
        'numeric' => 'Liczba :attribute musi być mniejsza lub równa :value.',
        'file' => 'Plik :attribute musi być mniejszy lub równy :value kb.',
        'string' => 'Ciąg :attribute musi być krótszy lub równy :value znaków.',
        'array' => 'Tablica :attribute nie może zawierać więcej niż :value elementów.',
    ],
    'max' => [
        'numeric' => 'Liczba :attribute nie może być większy niż :max.',
        'file' => 'Plik :attribute nie może być większy niż :max Kb.',
        'string' => 'Ciąg :attribute nie może być dłuższy niż :max znaków.',
        'array' => 'Tablica :attribute nie może zawierać więcej niż :max elementów.',
    ],
    'mimes' => 'Plik :attribute musi być typu: :values.',
    'mimetypes' => 'Plik :attribute musi być typu: :values.',
    'min' => [
        'numeric' => 'Liczba :attribute musi mieć wartość co namniej :min.',
        'file' => 'Plik :attribute musi mieć rozmiar co najmniej :min Kb.',
        'string' => 'Ciąg :attribute musi zawierać co najmniej :min znaków.',
        'array' => 'Tablica :attribute musi zawierać co namniej :min pozycji.',
    ],
    'not_in' => 'Wybrany :attribute jest nieprawidłowy.',
    'not_regex' => 'Format :attribute jest nieprawidłowy.',
    'numeric' => ':attribute musi być numeryczny.',
    'password' => 'Niepoprawne hasło.',
    'present' => ':attribute musi być aktualne.',
    'regex' => 'Format :attribute jest nieprawidłowy.',
    'required' => 'Pole :attribute jest wymagane.',
    'required_if' => 'Pole:attribute jest wymagane kiedy :other ma wartość :value.',
    'required_unless' => 'Pole :attribute jest wymagane kiedy pole :other nie ma wartości :values.',
    'required_with' => 'Pole :attribute jest wymagane gdy :values bieżącą wartość.',
    'required_with_all' => 'Pole :attribute jest wymagane, gdy :values jest w użyciu.',
    'required_without' => 'Pole :attribute jest wymagane, gdy :values nie jest w użyciu.',
    'required_without_all' => 'Pole :attribute jest wymagane, gdy żadna z :values nie jest w użyciu.',
    'same' => ':attribute oraz :other muszą być równe.',
    'size' => [
        'numeric' => ':attribute musi mieć wartość :size.',
        'file' => ':attribute musi mieć rozmiar :size Kb.',
        'string' => ':attribute musi zawierać :size znaków.',
        'array' => ':attribute musi zawierać :size pozycji.',
    ],
    'starts_with' => ':attribute musi zaczynać się od: :values.',
    'string' => ':attribute musi być ciągiem (string).',
    'timezone' => ':attribute musi być prawidłową nazwą strefy czasowej.',
    'unique' => ':attribute już jest w użyciu.',
    'uploaded' => 'Nie udało się wgrać :attribute.',
    'url' => 'Format :attribute jest niepoprawny.',
    'uuid' => ':attribute musi mieć poprawny format UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'loginad_u' => [
            'lowercase' => 'tylko małe litery dla pola login AD'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'password' => 'hasło',
        'username' => 'login',
        'ram_k' => 'pamięć RAM',
    ],

];
