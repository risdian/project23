@component('mail::message')
# Account Validation

Hai, {{ $name }}
Please click the link below and change add your password

@component('mail::button', ['url' => route('invitation.validate', ['token' => $token, 'email' => $email] ) ])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
