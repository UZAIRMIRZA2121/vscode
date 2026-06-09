@component('mail::message')
# Introduction

Hello,

Thank you for signing up! To activate your account, please click the button below to verify your email address.

@component('mail::button', ['url' => route('verification.verify.email', $verificationToken)])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
