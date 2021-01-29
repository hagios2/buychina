@component('mail::message')
# Hello {{ $shop->company_name }}

<p>
    You have requested to reset your password, kindly click on the link below to reset your password
</p>

@component('mail::button', ['url' => env('PASSWORD_SHOP_RESET_URL')."?token={$token->token}"])
    Reset Password
@endcomponent

<p>
    or you may copy and paste the link below in your browser to reset your password <br>

        {{env('PASSWORD_SHOP_RESET_URL')."?token={$token->token}"}}
</p>

<p>
    Please ignore this mail if you didn't perform this operation
</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent