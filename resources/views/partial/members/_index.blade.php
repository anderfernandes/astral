{!! Form::open(['route' => 'cashier.members.index', 'class' => 'ui form', 'method' => 'get']) !!}
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
              {{ $member->primary->fullname }}
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

  <a class="ui secondary button" href="{{ route('cashier.users.create') }}">
    <i class="ui icons">
      <i class="user icon"></i>
      <i class="inverted corner add icon"></i>
    </i>
    Add User
  </a>

  <a class="ui secondary button" href="{{ route('cashier.members.create') }}">
    <i class="ui icons">
      <i class="address card icon"></i>
      <i class="inverted corner add icon"></i>
    </i>
    Add Member
  </a>

  <br /><br />

  @if (!isSet($members) || count($members) > 0)
    <div class="ui four doubling link cards">
      @foreach($members as $member)
        <div class="card" onclick="window.location='{{ route('cashier.members.show', $member) }}'">
          <div class="content">
            <img src="{{ \App\Setting::find(1)->logo == '/logo.png' ? \App\Setting::find(1)->logo : Storage::url(\App\Setting::find(1)->logo) }}" alt="" class="left floated mini ui image">
            <div class="right floated meta"># {{ $member->number }}</div>
            <div class="header">{{ $member->primary->fullname }}</div>
            <div class="meta">
              {{ $member->type->name }}
            </div>
            <div class="meta">
              <i class="calendar alternate outline icon"></i>
              Expires {{ Date::parse($member->end)->format('l, F j, Y') }}
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

  <br /><br />

  <script>
    @if ($request->memberId)
      $('#member-id').dropdown('set exactly', {{ $request->memberId }})
    @endif
    @if ($request->memberType)
      $('#member-type').dropdown('set exactly', "{{ $request->memberType }}")
    @endif
  </script>