@extends('layout.admin')
@section('title', 'Shows')
@section ('subtitle', 'Manage Shows')
@section ('icon', 'film')

@section('content')

<div class="ui container">

  {!! Form::open(['route' => 'admin.shows.index', 'class' => 'ui form', 'method' => 'get', 'id' => 'search']) !!}
  <div class="five fields">
    <div class="field">
      <div class="ui selection search dropdown" id="show-id">
        <input type="hidden" name="id">
        <i class="dropdown icon"></i>
          <div class="default text">All Shows</div>
        <div class="menu">
          <div class="item" data-value="">All Shows</div>
          @foreach (App\Show::where('id', '!=', 1)->orderBy('name', 'asc')->get() as $show)
            <div class="item" data-value="{{ $show->id }}">
              {{ $show->name }}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <div class="ui right labeled input">
        <input type="text" value="{{ app('request')->duration ? app('request')->duration : null }}" name="duration" placeholder="Show Duration">
        <div class="ui basic label">minutes</div>
      </div>
    </div>
    <div class="field">
      <select id="showType" class="ui dropdown" name="type_id">
        <option value="">All Types</option>
        @foreach($showTypes as $id => $name)
        <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>
    <div class="field">
      <select id="isActive" class="ui dropdown" name="active">
        <option value="">Active or Inactive</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>
    <div class="field">
      {!! Form::button('<i class="search icon"></i> Search', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

<div onclick="$('#add-show').modal('show')" class="ui secondary button">
  <i class="ui icons">
    <i class="film icon"></i>
    <i class="inverted corner add icon"></i>
  </i>
  Add Show
</div>

<br /><br />

@if (!isSet($shows) || ($shows->count()) > 0)
  <div class="ui five doubling link cards">
    @foreach($shows as $show)
      <div class="card" onclick="location.href='{{ route('admin.shows.show', $show) }}'">
        <div class="content">
          <div class="header">
            {{ $show->name }}
          </div>
          <div class="meta">
            <div class="ui black label">{{ $show->category->name }}</div>
            <div class="ui black label">{{ $show->duration }} minutes</div>
            @if (!$show->active)
            <div class="ui red basic label">
              inactive
            </div>
            @endif
            @if ($show->expired)
            <div class="ui red label">
              expired
            </div>
            @endif
          </div>
        </div>
        <div href="{{ route('admin.shows.show', $show) }}" class="image">
          <img src="{{ (substr($show->cover, 0, 4) == ('http') || $show->cover == '/default.png') ? $show->cover : Storage::url($show->cover) }}">
        </div>
      </div>
    @endforeach
  </div>
@else
  <div class="ui info icon message">
    <i class="info circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        No shows!
      </div>
      <p>It looks like there are no shows in the database.</p>
    </div>
  </div>
@endif

</div>

<br /><br />

<div class="ui centered grid">
  {{ $shows->appends(app('request')->input())->links('vendor.pagination.semantic-ui') }}
</div>

<br /><br />

{{-- Add Show Modal --}}
@include('admin.partial.shows._create')

<script>
  @if (app('request')->has('id'))
    $('#show-id').dropdown('set exactly', {{ app('request')->id }})
  @endif
  @if (app('request')->has('type'))
    $('#showType').dropdown('set exactly', "{{ app('request')->type }}")
  @endif
  @if (app('request')->has('active'))
    $('#isActive').dropdown('set exactly', "{{ app('request')->active }}")
  @endif
</script>

@endsection
