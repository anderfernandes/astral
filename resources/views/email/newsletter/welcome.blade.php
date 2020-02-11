@component('vendor.mail.markdown.message')
  <p style="text-align:center">
    <img src="{{ asset(\App\Setting::find(1)->logo) }}" width="36" height="48" align="center" style="margin-bottom:12px" />
  </p>
  <h1 style="text-align:center">Thank you for signing up to our newsletter!</h1>

  Dear {{ $user->firstname }},

  Thank you for signing up to our newsletter!

  Keep an eye on your email. We will send you the latest on everything the 
  {{ \App\Setting::find(1)->organization }} has to educate and entertain you 
  and your family.

  In the mean time, please check our website using the button below.

  @component('mail::button', ['url' => 'http://' . \App\Setting::find(1)->website ])
  Go to the {{ \App\Setting::find(1)->organization }}'s website
  @endcomponent

  Regards,

  {{ \App\Setting::find(1)->organization }}
@endcomponent
