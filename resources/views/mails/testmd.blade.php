@component('mail::message')
# Gentile {{$user->name}}

Questa email è stata inviata dallo studio legale

@component('mail::button', ['url' => route('login')])
Please login
@endcomponent

Saluti,<br>
coordiali saluti <br>
    Avv. Aniello Cascione
@endcomponent
