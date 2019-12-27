@extends('layout.admin')

@section('title', 'Members')

@section('subtitle', 'Manage Members')

@section('icon', 'address card')

@section('content')

  <div class="ui container">

    {!! Form::open(['route' => 'admin.members.index', 'class' => 'ui form', 'method' => 'get']) !!}
    <div class="four fields">
      <div class="field">
        <div class="ui selection search dropdown" id="member-id">
          <input type="hidden" id="id" name="id">
          <i class="dropdown icon"></i>
            <div class="default text">All Members</div>
          <div class="menu">
            <div class="item" data-value="">All Members</div>
            @foreach (App\Member::where('id', '!=', 1)->get() as $member)
              <div class="item" data-value="{{ $member->id }}">
                {{ $member->primary->fullname }}
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <div class="field">
      <input type="text" value="{{ request()->query('membership_number') }}" name="membership_number" placeholder="Enter a membership number">
      </div>
      <div class="field">
        <div class="ui selection search dropdown" id="member-type">
          <input type="hidden" id="type" name="type">
          <i class="dropdown icon"></i>
            <div class="default text">All Membership Types</div>
          <div class="menu">
            <div class="item" data-value="">All Membership Types</div>
            @foreach (App\MemberType::where('id', '!=', 1)->orderBy('name', 'asc')->get() as $memberType)
              <div class="item" data-value="{{ $memberType->id }}">
                {{ $memberType->name }}
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <div class="field">
        {!! Form::button('<i class="search icon"></i> Search', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
      </div>
    </div>
    {!! Form::close() !!}

    <a class="ui secondary button" href="{{ route('admin.members.create') }}">
      <i class="ui icons">
        <i class="address card icon"></i>
        <i class="inverted corner add icon"></i>
      </i>
      Add Member
    </a>

    <a class="ui secondary button" href="{{ route('admin.members.wizard') }}">
      <i class="ui icons">
        <i class="address card alternate icon"></i>
        <i class="inverted corner add icon"></i>
      </i>
      New Member Wizard
    </a>

    <br /><br />

    @if (!isSet($members) || count($members) > 0)
      <div class="ui one doubling link cards">
        @foreach($members as $member)
          <div class="{{ $member->end->isPast() ? 'red' : '' }} card" onclick="window.location='{{ route('admin.members.show', $member) }}'">
            <div class="content">
              <img src="{{ \App\Setting::find(1)->logo == '/logo.png' ? \App\Setting::find(1)->logo : Storage::url(\App\Setting::find(1)->logo) }}" alt="" class="left floated mini ui image">
              <div class="right floated meta"># {{ $member->number }}</div>
              <div class="header">
                {{ $member->primary->fullname }}
                <div class="ui black label">
                  {{ $member->type->name }}
                </div>
                @if ($member->end->isPast())
                <div class="ui red label">
                  <i class="exclamation circle icon"></i>
                  expired
                </div>
                @endif
              </div>
              <div class="meta">
                <i class="calendar alternate outline icon"></i>
                {{ $member->end->isPast() ? 'Expired' : 'Expires' }}
                on {{ Date::parse($member->end)->format('l, F j, Y') }}
                ({{ $member->end->diffInDays(now()) }} days {{ $member->end->isPast() ? 'ago' : 'left' }})
              </div>
              <div class="meta">
                @if ($member->secondaries->count() > 0)
                <i class="address card icon"></i>
                {{ $member->secondaries->count() == 1 ? 'Dependent: ' : 'Dependents: ' }}
                @foreach ($member->secondaries as $secondary)
                <div class="ui basic label">
                  {{ $secondary->fullname }}
                </div>
                @endforeach
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="sixteen wide column">
        <div class="ui info icon message">
          <i class="info circle icon"></i>
          <i class="close icon"></i>
          <div class="content">
            <div class="header">
              No members!
            </div>
            <p>It looks like your search has returned no results or there are no members in the database.</p>
          </div>
        </div>
      </div>
    @endif

    <br /><br />

    <div class="ui centered grid">
      {{ $members->appends(app('request')->input())->links('vendor.pagination.semantic-ui') }}
    </div>

  </div>

  <br /><br />

  <script>
    @if (request()->has('id'))
      $('#member-id').dropdown('set exactly', {{ request()->query('id') }})
    @endif
    @if (request()->has('type'))
      $('#member-type').dropdown('set exactly', "{{ request()->query('type') }}")
    @endif
  </script>

@endsection
