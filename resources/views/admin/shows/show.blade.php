@extends('layout.admin')

@section('title', 'Show Information')

@section('subtitle', $show->name)

@section('icon', 'book')

@section('content')

  <div class="ui container">
    <a href="{{ route('admin.shows.index') }}?active=1" class="ui basic black button">
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
          <br>
          @if ($show->trailer_url)
          <div class="ui fluid black button" onclick="$('.ui.trailer.fullscreen.modal').modal('toggle')">
            <i class="film icon"></i>
            View Trailer
          </div>
          @endif
        </div>
        <div class="content">
          <div class="ui huge header">{{ $show->name }}</div>
          <div class="meta">
            <div class="ui black label">{{ $show->category->name }}</div>
            <div class="ui black label">
              <i class="clock icon"></i> <div class="detail">{{ $show->duration }} minutes</div>
            </div>
            <a href="{{ route('admin.users.show', $show->creator) }}" target="_blank" class="ui black label">
              <i class="user circle icon"></i>
              <span class="detail">{{ $show->creator->fullname }}</span>
            </a>
            @if ($show->expiration)
            <div class="ui {{ $show->expired ? 'red' : 'green' }} label">
              <i class="hourglass end icon"></i> 
              {{ $show->expiration->format('l, F j, Y') }}
              <div class="detail">
                ({{ $show->expiration->diffForHumans() }})
              </div>
            </div>
            @endif
            @if (!$show->active)
            <div class="ui red basic label">
              inactive
            </div>
            @endif
            @if (!$show->expired)
            <div class="ui red label">
              expired
            </div>
            @endif
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

  <div class="ui basic trailer fullscreen modal">
    <div class="actions">
      <div class="ui ok inverted button">
        <i class="close icon"></i>
        Close
      </div>
    </div>
    <div class="content">
        @if ($show->trailer_url)
        <?php 
          parse_str(parse_url($show->trailer_url, PHP_URL_QUERY), $video_url)
        ?>
        <div class="ui 16:9 embed" data-source="youtube" data-id="{{ $video_url['v'] }}" data-placeholder="{{ $show->cover }}"></div>
      @endif
    </div>
  </div>

  <script>
    $('.ui.embed').embed()
  </script>

  <style>
    .ui.embed > .placeholder { 
      width: inherit !important ;
      transform: translate(-50%, -50%) !important;
      left: 50% !important;
      top: 50% !important;
    }
  </style>

  @include('admin.partial.shows._edit')

  @include('admin.partial._basic-modal', [
    'id'        => 'delete-show',
    'icon'      => 'trash',
    'title'     => "You are about to delete a show!",
    'subtitle'  => "Are you sure you want to permanently delete the <strong>{$show->category->name}</strong> show <strong>{$show->name}</strong> ?",
    'actions'   => "<a href='/admin/shows/{$show->id}/delete' class='ui inverted red button'><i class='trash icon'></i>Yes, Delete {$show->name}</a>",
  ])

@endsection
