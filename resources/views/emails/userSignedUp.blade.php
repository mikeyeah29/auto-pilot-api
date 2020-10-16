@component('mail::message')
# Introduction

Hey, You Signed up! Thats great there...

You should probably go ahead and click the link below to complete validation.

@component('mail::button', ['url' => ''])
Validate
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
