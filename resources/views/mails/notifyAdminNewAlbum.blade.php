@component('mail::message')
   <h1> Hello{{$admin->name}} </h1>
 {{$album->album_name}}



@component('mail::button', ['url' => route('albums.edit', $album->id)])
    {{$album->album_name}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
