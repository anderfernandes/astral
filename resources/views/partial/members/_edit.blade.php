<div class="sixteen wide column">
  {{ Session::flash('info',
    'Make sure you make the right changes here. Pay very close attention to free and non-free secondaries as well as membership start/end dates and membership type!')
  }}

@include('admin.members._form')