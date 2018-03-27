@extends('layout.admin')

@section('title', 'Organizations')

@section('subtitle', 'Manage Organizations')

@section('icon', 'university')

@section('content')

  {!! Form::open(['route' => 'admin.organizations.index', 'class' => 'ui form', 'method' => 'get']) !!}
  <div class="five fields">
    <div class="field">
      <div class="ui selection search dropdown" id="organization-id">
        <input type="hidden" id="organizationId" name="organizationId">
        <i class="dropdown icon"></i>
          <div class="default text">All Organizations</div>
        <div class="menu">
          <div class="item" data-value="">All Organizations</div>
          @foreach (App\Organization::where('type_id', '!=', 1)->orderBy('name', 'asc')->get() as $organization)
            <div class="item" data-value="{{ $organization->id }}">
              {{ $organization->name }}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <div class="ui selection search dropdown" id="organization-type-id">
        <input type="hidden" id="organizationTypeId" name="organizationTypeId">
        <i class="dropdown icon"></i>
          <div class="default text">All Organization Types</div>
        <div class="menu">
          <div class="item" data-value="">All Organization Types</div>
          @foreach (App\OrganizationType::where('name', '!=', 'System')->orderBy('name', 'asc')->get() as $organizationType)
            <div class="item" data-value="{{ $organizationType->id }}">
              {{ $organizationType->name }}
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

  <div class="ui secondary button" onclick="$('#add-organization').modal('show')">
    <i class="plus icon"></i> Add Organization
  </div>

  <br /><br />

@if (!isset($organizations) || count($organizations) > 0)
  <div class="ui four doubling link cards">
    @foreach($organizations as $organization)
    <div class="card" onclick="window.location.href='{{ route('admin.organizations.show', $organization) }}'">
      <div class="content">
        <i class="university huge right floated icon"></i>
        <div class="header">{{ $organization->name }}</div>
        <div class="meta">
          <div class="ui label">{{ $organization->type->name }}</div>
        </div>
        <div class="meta">
          <i class="phone icon"></i> {{ $organization->phone }}
        </div>
        <div class="meta">
          <i class="mail icon"></i> {{ $organization->email }}
        </div>
      </div>
      <div class="ui two bottom attached buttons">
        <a href="{{ route('admin.organizations.show', $organization) }}" class="ui black button">
          <i class="eye icon"></i> View
        </a>
        <a href="{{ route('admin.organizations.edit', $organization ) }}" class="ui blue button">
          <i class="edit icon"></i> Edit
        </a>
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
        No organizations!
      </div>
      <p>It looks like there are no organizations in the database.</p>
    </div>
  </div>
@endif

<br /><br />

<div class="ui centered grid">
  {{ $organizations->appends(app('request')->input())->links('vendor.pagination.semantic-ui') }}
</div>

{{-- Add Organization Modal --}}
@component('admin.partial._modal', [
  'id' => 'add-organization',
  'icon' => 'plus',
  'title' => 'Add Organization'
])
  @slot('content')
    @include('admin.partial.organizations._create')
  @endslot
@endcomponent

<script>
  @if ($request->organizationId)
    $('#organization-id').dropdown('set exactly', {{ $request->organizationId }})
  @endif
  @if ($request->organizationTypeId)
    $('#organization-type-id').dropdown('set exactly', "{{ $request->organizationTypeId }}")
  @endif
</script>

@endsection
