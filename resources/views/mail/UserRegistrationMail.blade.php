@component('mail::message')
# Welcome {{ $user->name }} <br>

You have successfully registered with Martek-Gh. Kindly click on the button to verify your email

@component('mail::button', ['url' => env('FRONT_EMD_URL')."/api/auth/email/verify?token={$token->token}"])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent