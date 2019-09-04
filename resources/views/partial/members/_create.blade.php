{{ Session::flash('info',
    'Make sure you make the right person a member. Membership status will only be granted upon payment.')
  }}

  @include('partial.members._form')