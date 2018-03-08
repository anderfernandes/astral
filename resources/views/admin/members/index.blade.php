@extends('layout.admin')

@section('title', 'Members')

@section('subtitle', 'Manage Members')

@section('icon', 'address card')

@section('content')

  {!! Form::open(['route' => 'admin.members.index', 'class' => 'ui form', 'method' => 'get']) !!}
  <div class="five fields">
    <div class="field">
      <div class="ui selection search dropdown" id="member-id">
        <input type="hidden" id="memberId" name="memberId">
        <i class="dropdown icon"></i>
          <div class="default text">All Members</div>
        <div class="menu">
          <div class="item" data-value="">All Members</div>
          @foreach (App\Member::where('id', '!=', 1)->get() as $member)
            <div class="item" data-value="{{ $member->id }}">
              {{ $member->users[0]->fullname }}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <input type="text" value="{{ $request->membershipNumber ? $request->membershipNumber : null }}" name="membershipNumber" placeholder="Enter a membership number">
    </div>
    <div class="field">
      <div class="ui selection search dropdown" id="member-type">
        <input type="hidden" id="membershipType" name="memberType">
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
    <i class="plus icon"></i> Add Member
  </a>

  <br /><br />

  @if (!isSet($members) || count($members) > 0)
    <div class="ui four doubling link cards">
      @foreach($members as $member)
        <div class="card">
          <div class="content">
            <img src="/{{ App\Setting::find(1)->logo }}" alt="" class="left floated mini ui image">
            <div class="right floated meta"># {{ $member->id }}</div>
            <div class="header">{{ $member->users[0]->fullname }}</div>
            <div class="meta">
              <div class="ui label">{{ $member->type->name }}</div>
            </div>
            <div class="meta">
              <i class="checked calendar icon"></i>
              Expires {{ Date::parse($member->end)->format('l, F j, Y') }}
            </div>
          </div>
          <a href="{{ route('admin.members.show', $member) }}" class="ui primary bottom attached button">
            <i class="eye icon"></i> View
          </a>
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
    {{ $members->links('vendor.pagination.semantic-ui') }}
  </div>

  <br /><br />

  <script>
    @if ($request->memberId)
      $('#member-id').dropdown('set exactly', {{ $request->memberId }})
    @endif
    @if ($request->memberType)
      $('#member-type').dropdown('set exactly', "{{ $request->memberType }}")
    @endif
  </script>

@endsection
