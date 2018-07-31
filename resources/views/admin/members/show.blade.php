@extends('layout.admin')

@section('title', 'Member Information')

@section('subtitle', $member->users[0]->firstname.' '.$member->users[0]->lastname)

@section('icon', 'address card')

@section('content')


  <a href="{{ route('admin.members.index') }}" class="ui basic black button">
    <i class="left chevron icon"></i> Back
  </a>
  <a href="{{ route('admin.users.edit', $member->users[0]) }}" class="ui yellow button">
    <i class="edit icon"></i> Edit Member
  </a>
  <a href="{{ route('admin.members.create') }}" class="ui secondary button">
    <i class="ui icons">
      <i class="address card icon"></i>
      <i class="inverted corner add icon"></i>
    </i>
    Add Another Member
  </a>

  @if ($member->users->count() - 1 >= $member->type->max_secondaries)
    <a onclick="$('#secondary').modal('show')" class="ui black disabled button">
      <i class="ui icons">
        <i class="address card icon"></i>
        <i class="inverted corner add icon"></i>
      </i>
      Add a Secondary
    </a>
  @else
    <a onclick="$('#secondary').modal('show')" class="ui black button">
      <i class="ui icons">
        <i class="address card icon"></i>
        <i class="inverted corner add icon"></i>
      </i>
      Add a Secondary
    </a>
  @endif

  <a href="{{ route('admin.members.edit', $member) }}" class="ui black button">
    <i class="refresh icon"></i> Renew Membership
  </a>
  <div class="ui dropdown black button">
    <i class="copy icon"></i> Documents
    <i class="dropdown icon"></i>
    <div class="menu">
      <a href="{{ route('admin.members.receipt', $member) }}" target="_blank" class="item">
        <i class="file icon"></i>Receipt
      </a>
      <a href="{{ route('admin.members.card', $member) }}" target="_blank" class="item">
        <i class="file icon"></i> Card
      </a>
      <a href="{{ route('admin.members.receipt', $member) }}?format=pdf" target="_blank" class="item">
        <i class="file pdf icon"></i>Receipt
      </a>
      <a href="{{ route('admin.members.card', $member) }}?format=pdf" target="_blank" class="item">
        <i class="file pdf icon"></i> Card
      </a>
    </div>
  </div>
  <a href="{{ route('admin.members.card', $member) }}" target="_blank" class="ui black button">
    <i class="address card icon"></i> View Card
    <i class="right chevron icon"></i>
  </a>

  <div class="ui large dividing header">
    <i class="address card icon"></i>
    <div class="content">
      {{ $member->users[0]->fullname }}
      <div class="ui black label">{{ $member->type->name }}</div>
      <div class="sub header">
        @if ($member->creator_id != 1)
        <i class="user circle icon"></i> {{ $member->creator->firstname }} |
        @endif
        <i class="pencil icon"></i>{{ $member->created_at->format('l, F j, Y \a\t g:i:s A') }}
        ({{ $member->created_at->diffForHumans() }})
      </div>
    </div>
  </div>
  <div class="ui four column stackable grid">
    <div class="column">
      <div class="ui header">
        {{ $member->users[0]->address }}
        <div class="sub header">Address</div>
      </div>
      <div class="ui header">
        {{ $member->users[0]->email }}
        <div class="sub header">Email</div>
      </div>
    </div>
    <div class="column">
      <div class="ui header">
        {{ $member->users[0]->city }}
        <div class="sub header">City</div>
      </div>
    </div>
    <div class="column">
      <div class="ui header">
        {{ $member->users[0]->state }}
        <div class="sub header">State</div>
      </div>
    </div>
    <div class="column">
      <div class="ui header">
        {{ $member->users[0]->zip }}
        <div class="sub header">ZIP</div>
      </div>
    </div>
  </div>

  <br />

  <h4 class="ui center aligned horizontal divider header">
    <i class="info circle icon"></i> Membership Details
  </h4>

  <table class="ui very basic unstackable table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($member->users as $key => $user)
      <tr>
        <td>
          <h4 class="ui header">
            <i class="address card icon"></i>
            <div class="content">
              {{ $user->firstname . ' ' . $user->lastname }}
              <div class="sub header">
                {{ $member->type->name }}
                @if ($key != 0)
                  (Secondary)
                @endif
              </div>
            </div>
          </h4>
        </td>
        <td></td>
      </tr>
      @endforeach

    </tbody>
  </table>

  <div class="ui basic modal" id="secondary">
    <div class="ui icon header">
      <i class="address card icon"></i>
      Add Secondary
    </div>
    {!! Form::model($member, ['route' => ['admin.members.addSecondary', $member], 'class' => 'ui form', 'method' => 'PUT']) !!}
    <div class="content">
      <p style="text-align:center">Who do you want to make a secondary for this membership?</p>
      <div class="field">
        {!! Form::select('user_id', $users, null, ['placeholder' => 'Who do you want to turn into a member?', 'class' => 'ui search dropdown']) !!}
      </div>
      <div class="field">
        {!! Form::button('<i class="checkmark icon"></i> Add Secondary', ['type' => 'submit', 'class' => 'ui green ok inverted button']) !!}
      </div>
    </div>
    {!! Form::close() !!}
    <div class="actions">
      <div class="ui red basic cancel inverted button">
        <i class="remove icon"></i>
        Cancel
      </div>
    </div>
  </div>

@endsection
