@extends('layout.admin')
@section('title', 'Shows')
@section ('subtitle', 'Manage Shows')
@section ('icon', 'film')

@section('content')

  {!! Form::open(['route' => 'admin.shows.index', 'class' => 'ui form', 'method' => 'get', 'id' => 'search']) !!}
  <div class="four fields">
    <div class="field">
      <div class="ui selection search dropdown" id="show-id">
        <input type="hidden" name="id">
        <i class="dropdown icon"></i>
          <div class="default text">All Shows</div>
        <div class="menu">
          <div class="item" data-value="">All Shows</div>
          @foreach (App\Show::where('id', '!=', 1)->get() as $show)
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
      <select id="showType" class="ui dropdown" name="type">
        <option value="">All Types</option>
        <option value="Planetarium">Planetarium</option>
        <option value="Laser Light">Laser Light</option>
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
      <div class="card" onclick="window.open('{{ route('admin.shows.show', $show) }}', '_blank')">
        <div class="content">
          <div class="header">
            {{ $show->name }}
          </div>
          <div class="meta">
            <div class="ui black label">{{ $show->type }}</div><div class="ui black label">{{ $show->duration }} minutes</div>
          </div>
        </div>
        <div href="{{ route('admin.shows.show', $show) }}" class="image">
          <img src="{{ $show->cover }}">
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

<br /><br />

<div class="ui centered grid">
  {{ $shows->appends(app('request')->input())->links('vendor.pagination.semantic-ui') }}
</div>

<br /><br />

{{-- Add Show Modal --}}
@include('admin.partial.shows._create')

<script>
  @if (app('request')->id)
    $('#show-id').dropdown('set exactly', {{ app('request')->id }})
  @endif
  @if (app('request')->type)
    $('#showType').dropdown('set exactly', "{{ app('request')->type }}")
  @endif
</script>

@endsection
