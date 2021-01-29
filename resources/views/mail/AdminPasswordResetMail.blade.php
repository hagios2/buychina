@component('mail::message')
# Hello {{ $admin->name }}

<p>
    You have requested to reset your password, kindly click on the link below to reset your password
</p>

@component('mail::button', ['url' => env('PASSWORD_RESET_URL')."?token={$token->token}"])
    Reset Password
@endcomponent

<p>
    or you may copy and paste the link below in your browser to reset your password <br>

        {{env('PASSWORD_ADMIN_RESET_URL')."?token={$token->token}"}}
</p>

<p>
    Please ignore this mail if you didn't perform this operation
</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent