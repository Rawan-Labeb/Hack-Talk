<x-mail::message>
Halk-Talk reset password <br>
Hello {{ $name }},

<p>Your Reset password is <b style="color: green"> {{ $token }} </b></p>

Thanks,
{{ config('app.name') }}
</x-mail::message>
