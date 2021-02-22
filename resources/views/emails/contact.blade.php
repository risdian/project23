@component('mail::message')
# Account Validation

Hai, {{ $name }}
Congratulation you have been invited to join Al ikhlas personal shopper.
Please click the link below and change add your password

@component('mail::button', ['url' => route('invitation.validate', ['token' => $token, 'email' => $email] ) ])
Reset Password
@endcomponent

Thanks You,<br>
{{ config('app.name') }}
@endcomponent
