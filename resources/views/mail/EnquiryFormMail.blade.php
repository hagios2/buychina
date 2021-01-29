@component('mail::message')
# Hello Martek, <br>

<section>

    <p>

        {{ $formInputs['message'] }}
        
    </p>

</section>

Thanks,
<p>
    {{ $formInputs['name'] }} <br>
    Tel:&emsp; {{ $formInputs['phone'] }} <br>
    Email: &emsp; {{ $formInputs['email']}}
</p>
@endcomponent
