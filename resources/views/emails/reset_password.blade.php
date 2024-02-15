<x-mail::message>
Bonjour  {{ $users->name }}

Your adidas password can be reset by clicking the button below. 
If you did not request a new password, please ignore this email.

<x-mail::button :url="url('/new/password/' . $token)">
click here to reset your password
</x-mail::button>
Thanks,<br>
Adidas
</x-mail::message>
