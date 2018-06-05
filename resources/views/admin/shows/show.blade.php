@extends('layout.admin')

@section('title', 'Show Information')

@section('subtitle', $show->name)

@section('icon', 'book')

@section('content')

  <div class="ui container">

    <div class="ui buttons">

      <a href="{{ route('admin.shows.index') }}" class="ui basic black button">
        <i class="left chevron icon"></i> Back
      </a>
      <a href="javascript:$('#edit-show').modal('show')" class="ui black button">
        <i class="icons"><i class="film icon"></i><i class="corner inverted edit icon"></i></i> Edit Show
      </a>
      <a href="{{ route('admin.shows.create') }}" class="ui black button">
        <i class="icons"><i class="film icon"></i><i class="corner inverted add icon"></i></i> Add Another Show
      </a>
      @if(str_contains(Auth::user()->role->permissions['shows'], "D"))
        <div class="ui red button" onclick="$('#delete-show').modal('toggle')"><i class="trash icon"></i>Delete Show</div>
      @endif

    </div>


    <div class="ui items">
      <div class="item">
        <div class="ui rounded medium image">
          <img src="{{ $show->cover }}" alt="">
        </div>
        <div class="content">
          <div class="ui huge header">{{ $show->name }}</div>
          <div class="meta">
            <div class="ui black label">{{ $show->type }}</div>
            <div class="ui black label">{{ $show->duration }} minutes</div>
            <a href="{{ route('admin.users.show', $show->creator) }}" target="_blank" class="ui black label"><i class="user circle icon"></i> {{ $show->creator->fullname }}</a>
          </div>
          <div class="meta"></div>
          <div class="extra">
            <div class="ui black label">
              <i class="pencil icon"></i>
              <div class="detail">
                {{ $show->created_at->format('l, F j, Y \a\t g:i A') }} ({{ $show->created_at->diffForHumans() }})
              </div>
            </div>
            <div class="ui black label">
              <i class="edit icon"></i>
              <div class="detail">
                {{ Date::parse($show->updated_at)->format('l, F j, Y \a\t g:i A') }} ({{ Date::parse($show->updated_at)->diffForHumans() }})
              </div>
            </div>
          </div>
          <div class="description">
            {!! \Illuminate\Mail\Markdown::parse($show->description) !!}</div>
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
