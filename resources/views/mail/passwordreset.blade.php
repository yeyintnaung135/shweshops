@component('mail::message')
    <div style="text-align: center;">Your Password Reset Code :
    </div>
    <h2 style="text-align: center;">{{$code}}</h2>
    <br>
{{--{{ config('app.name') }}--}}
@endcomponent
