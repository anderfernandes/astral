@if ($type == 'create')
  {!! Form::open(['route' => 'admin.users.store', 'class' => 'ui form']) !!}
@else
  {!! Form::model($user, ['route' => ['admin.users.update', $user], 'class' => 'ui form', 'method' => 'PUT']) !!}
@endif
<div class="two fields">
  <div class="required field">
    {!! Form::label('firstname', 'First Name') !!}
    {!! Form::text('firstname', null, ['placeholder' => 'First Name']) !!}
  </div>
  <div class="required field">
    {!! Form::label('lastname', 'Last Name') !!}
    {!! Form::text('lastname', null, ['placeholder' => 'Last Name']) !!}
  </div>
</div>
<div class="two fields">
  <div class="required field">
    {!! Form::label('address', 'Address') !!}
    {!! Form::text('address', null, ['placeholder' => 'Enter full organization address']) !!}
  </div>
  <div class="required field">
    {!! Form::label('city', 'City') !!}
    {!! Form::text('city', null, ['placeholder' => 'Enter organization\'s city']) !!}
  </div>
</div>
<div class="three fields">
  <div class="required field">
    {!! Form::label('country', 'Country') !!}
    @include('partial._countries')
  </div>
  <div class="required field">
    {!! Form::label('state', 'State') !!}
    @include('partial._states')
  </div>
  <div class="required field">
    {!! Form::label('zip', 'ZIP') !!}
    {!! Form::text('zip', null, ['placeholder' => 'ZIP']) !!}
  </div>
</div>
<div class="three fields">
  <div class="required field">
    {!! Form::label('phone', 'Phone') !!}
    {!! Form::tel('phone', null, ['placeholder' => 'Enter user\'s phone number']) !!}
  </div>
</div>
<div class="three fields">
  <div class="required field">
    {!! Form::label('role_id', 'Role') !!}
    @if (isSet($user))
      {!! Form::select('role_id', $roles, $user->role_id, ['class' => 'ui dropdown']) !!}
    @else
      {!! Form::select('role_id', $roles, 7, ['class' => 'ui dropdown']) !!}
    @endif

  </div>
  <div class="required field">
    {!! Form::label('organization_id', 'Organization') !!}
    @if (isSet($user))
      {!! Form::select('organization_id', $organizations, $user->organization_id, ['class' => 'ui search selection dropdown']) !!}
    @else
      {!! Form::select('organization_id', $organizations, 1, ['class' => 'ui search selection dropdown']) !!}
    @endif
  </div>
  <div class="required field">
    {!! Form::label('email', 'Email') !!}
    {!! Form::text('email', null, ['placeholder' => 'Email']) !!}
  </div>
</div>
<div class="required field">
  @if (Request::routeIs('admin.users.create') or Request::routeIs('admin.users.edit'))
  <div class="ui buttons">
    <a href="{{ route('admin.users.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
    <div class="ui positive right floated right labeled submit icon button">Save <i class="checkmark icon"></i></div>
  </div>
  @else
    <div class="ui positive right floated right labeled submit icon button">Save <i class="checkmark icon"></i></div>
  @endif
</div>
{!! Form::close() !!}

<script>
  var tel = document.querySelectorAll('[type="tel"]');
  for (var i = 0; i < tel.length; i++) {
    tel[i].addEventListener('input', function(e) {
      var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
      e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    })
  }

  {{-- Client Side Form Validation --}}
  $('form').form({
    inline: true,
    fields: {
      firstname: {
        identifier: 'firstname',
        rules: [
          { type: 'empty', prompt: 'Do not forget to enter this user\'s {name}!' },
          { type: 'minLength[2]', prompt: '{name} should be at least {ruleValue} characters long'}
        ]
      },
      lastname: {
        identifier: 'lastname',
        rules: [
          { type: 'empty', prompt: 'Do not forget to enter this user\'s {name}!' },
          { type: 'minLength[2]', prompt: '{name} should be at least {ruleValue} characters long'}
        ]
      },
      address: {
        identifier: 'address',
        rules: [
          { type: 'empty', prompt: 'Do not forget to enter this user\'s {name}!' },
          { type: 'minLength[5]', prompt: '{name} should be at least {ruleValue} characters long'}
        ]
      },
      city: {
        identifier: 'city',
        rules: [
          { type: 'empty', prompt: 'Do not forget to enter this user\'s {name}!' },
          { type: 'minLength[2]', prompt: '{name} should be at least {ruleValue} characters long'}
        ]
      },
      zip: {
        identifier: 'zip',
        rules: [
          { type: 'empty', prompt: 'Do not forget to enter this user\'s {name}!' },
          { type: 'integer', prompt: '{name} should be an integer' },
          { type: 'minLength[5]', prompt: '{name} should be at least {ruleValue} characters long'},
        ]
      },
      phone: {
        identifier: 'phone',
        rules: [
          { type: 'empty', prompt: 'Do not forget to enter this user\'s {name}!' },
        ]
      },
      email: {
        identifier: 'email',
        rules: [
          { type: 'empty', prompt: 'Do not forget to enter this user\'s {name}!' },
        ]
      }
    }
  })
</script>
