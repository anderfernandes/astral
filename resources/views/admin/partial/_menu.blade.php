<div class="ui borderless inverted fixed top menu">
  <a class="header toc item"><i class="sidebar large icon"></i></a>
  <a href="{{ route('admin.index')}}" class="item"><i class="dashboard large icon"></i></a>
  <a href="{{ route('admin.shows.index')}}" class="item"><i class="film large icon"></i></a>
  <a href="{{ route('admin.events.index') }}" class="item"><i class="large calendar icon"></i></a>
  <a href="{{ route('admin.users.index') }}" class="item"><i class="users large icon"></i></a>
  <div class="right menu">
    <a class="item">
      <i class="user circle outline large inverted icon"></i>
      {!! Auth::user()->firstname !!} &nbsp;
    </a>
  </div>
</div>
