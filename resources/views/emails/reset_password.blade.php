<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="'localhost:8000/new/password/{{$token}}'">
click here to reset your password
</x-mail::button>
<p>localhost:8000/new/password/{{$token}}</p>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
