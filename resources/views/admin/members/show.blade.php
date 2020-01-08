@extends('layout.admin')

@section('title', 'Member Information')

@section('subtitle', $member->primary->fullname)

@section('icon', 'address card')

@section('content')

  <div class="ui container">

    @if($member->end->isPast())
    <div class="ui red icon message">
      <i class="exclamation circle icon"></i>
      <div class="content">
        <div class="header">
          {{ $member->primary->fullname }}'s membership expired {{ $member->end->diffInDays(now()) }}
          {{ $member->end->diffInDays(now()) == 1 ? 'day' : 'days' }} ago!
        </div>
        Ask {{ $member->firstname }} to renew their membership so that they can keep
        enjoying membership benefits and supporting {{ App\Setting::find(1)->organization }}!
      </div>
    </div>
    @endif

    <a href="{{ route('admin.members.index') }}" class="ui basic black button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="{{ route('admin.users.edit', $member->primary) }}" class="ui yellow button">
      <i class="edit icon"></i> Edit Member
    </a>
    <a href="{{ route('admin.members.create') }}" class="ui secondary button">
      <i class="ui icons">
        <i class="address card icon"></i>
        <i class="inverted corner add icon"></i>
      </i>
      Add Another Member
    </a>

    @if ($member->secondaries->count() >= $member->type->max_secondaries)
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

    <a href="{{ route('admin.members.edit', $member) }}" class="ui yellow button">
      <i class="edit icon"></i> Edit/Renew Membership
    </a>
    <div class="ui dropdown black button">
      <i class="copy icon"></i> Documents
      <i class="dropdown icon"></i>
      <div class="menu">
        <a href="{{ route('admin.members.receipt', $member) }}" target="_blank" class="item">
          <i class="file icon"></i>Receipt
        </a>
        <a href="{{ route('admin.members.card', $member) }}" target="_blank" class="item">
          <i class="address card icon"></i> Card
        </a>
        <a href="{{ route('admin.members.receipt', $member) }}?format=pdf" target="_blank" class="item">
          <i class="file pdf icon"></i>Receipt
        </a>
      </div>
    </div>

    <div class="ui large dividing header">
      <i class="address card icon"></i>
      <div class="content">
        # {{ $member->number }} - 
        {{ $member->primary->fullname }}
        <div class="ui black label">{{ $member->type->name }}</div>
        <div class="sub header">
          @if ($member->creator_id != 1)
          <i class="user circle icon"></i> {{ $member->creator->firstname }} |
          @endif
          <i class="pencil icon"></i>{{ $member->created_at->format('l, F j, Y \a\t g:i:s A') }}
          ({{ $member->created_at->diffForHumans() }}) |
          <i class="edit icon"></i>{{ $member->updated_at->format('l, F j, Y \a\t g:i:s A') }}
        </div>
      </div>
    </div>
    <div class="ui four column stackable grid">
      <div class="column">
        <div class="ui header">
          {{ $member->primary->address }}
          <div class="sub header">Address</div>
        </div>
        <div class="ui header">
          {{ $member->primary->email }}
          <div class="sub header">Email</div>
        </div>
      </div>
      <div class="column">
        <div class="ui header">
          {{ $member->primary->city }}
          <div class="sub header">City</div>
        </div>
        <div class="ui header">
          {{ $member->start->format('l, F j, Y') }}
          <div class="sub header">Start Date</div>
        </div>
      </div>
      <div class="column">
        <div class="ui header">
          {{ $member->primary->state }}
          <div class="sub header">State</div>
        </div>
        <div class="ui {{ $member->end->isPast() ? 'red' : '' }} header">
          {{ $member->end->format('l, F j, Y') }}
          <div class="sub header">
            Expiration Date 
            ({{ $member->end->diffInDays(now()) }} days {{ $member->end->isPast() ? 'ago' : 'left' }})
          </div>
        </div>
      </div>
      <div class="column">
        <div class="ui header">
          {{ $member->primary->zip }}
          <div class="sub header">ZIP</div>
        </div>
      </div>
    </div>

    <br />

    @if ($member->secondaries->count() == 0)
      <div class="ui icon info message">
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">No secondaries</div>
          <p>This membership has no secondaries.</p>
        </div>
      </div>
    @else
      <table class="ui very basic unstackable table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($member->secondaries as $secondary)
              <tr>
                <td>
                  <a class="ui small header" href="{{ route('admin.users.show', $secondary) }}">
                    <i class="address card outline icon"></i>
                    <div class="content">
                      {{ $secondary->fullname }}
                      <div class="sub header">
                        {{ $member->type->name }} (Secondary)
                      </div>
                    </div>
                  </a>
                </td>
                <td>
                  <div class="ui icon buttons">
                    <a href="{{ route('admin.users.edit', $secondary) }}" target="_blank" class="ui yellow button">
                      <i class="edit icon"></i>
                    </a>
                    <a href="{{ route('admin.members.card', $member) }}?index={{ $loop->index }}" target="_blank" class="ui black button">
                      <i class="address card icon"></i>
                    </a>
                  </div>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    @endif

  </div>


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
