@extends('layout.admin')

@section('title', 'Show Information')

@section('subtitle', $show->name)

@section('icon', 'book')

@section('content')

  <div class="ui container">
    <a href="{{ route('admin.shows.index') }}" class="ui basic black button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="javascript:$('#edit-show').modal('show')" class="ui yellow button">
      <i class="edit icon"></i>
      Edit Show
    </a>
    <a href="{{ route('admin.shows.create') }}" class="ui black button">
      <i class="ui icons">
        <i class="film icon"></i>
        <i class="inverted corner add icon"></i>
      </i>
      Add Another Show
    </a>
    @if(str_contains(Auth::user()->role->permissions['shows'], "D"))
      <div class="ui red button" onclick="$('#delete-show').modal('toggle')">
        <i class="trash icon"></i> Delete Show
      </div>
    @endif
    <div class="ui items">
      <div class="item">
        <div class="ui rounded medium image">
          {{-- This will make Astral always show the right show cover wheter a URL or local storaged  --}}
          <img src="{{ (substr($show->cover, 0, 4) == ('http') || $show->cover == '/default.png') ? $show->cover : Storage::url($show->cover) }}">
        </div>
        <div class="content">
          <div class="ui huge header">{{ $show->name }}</div>
          <div class="meta">
            <div class="ui black label">{{ $show->type }}</div>
            <div class="ui black label">
              <i class="clock icon"></i> <div class="detail">{{ $show->duration }} minutes</div>
            </div>
            <a href="{{ route('admin.users.show', $show->creator) }}" target="_blank" class="ui black label">
              <i class="user circle icon"></i>
              <span class="detail">{{ $show->creator->fullname }}</span>
            </a>
          </div>
          <div class="ui header">
            <div class="sub header">
              <i class="pencil icon"></i> {{ $show->created_at->format('l, F j, Y \a\t g:i A') }} ({{ $show->created_at->diffForHumans() }}) |
              <i class="edit icon"></i> {{ $show->updated_at->format('l, F j, Y \a\t g:i A') }} ({{ $show->updated_at->diffForHumans() }})
            </div>
          </div>
          <div class="description">
            {!! \Illuminate\Mail\Markdown::parse($show->description) !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('admin.partial.shows._edit')

  @include('admin.partial._basic-modal', [
    'id'       => 'delete-show',
    'icon'     => 'trash',
    'title'    => "You are about to delete a show!",
    'subtitle' => "Are you sure you want to permanently delete the <strong>{$show->type}</strong> show <strong>{$show->name}</strong> ?",
    'actions'  => "<a href='/admin/shows/{$show->id}/delete' class='ui inverted red button'><i class='trash icon'></i>Yes, Delete {$show->name}</a>"
  ])

@endsection
