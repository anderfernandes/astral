@if ($announcements->count() > 0)
{{-- Modal --}}
<div class="ui modal" id="announcement">
  <i class="close icon"></i>
  <div class="ui header">
    <i class="announcement icon"></i>
    Announcements
  </div>
  <div class="scrolling content">
    @foreach ($announcements as $announcement)
    <div class="ui dividing header" style="margin-bottom: 0 !important">
      <div class="content">
        {{ $announcement->title }}
        <div class="sub header">
          <i class="user circle icon"></i>{{ $announcement->creator->firstname }}
          <div class="ui black tiny label">{{ $announcement->creator->role->name }}</div>
          <i class="calendar alternate outline icon"></i>
          {{ $announcement->updated_at->format('l, F j, Y \a\t g:i A') }}
          ({{ $announcement->updated_at->diffForHumans() }})
        </div>
      </div>
    </div>
    <div class="ui divided list" style="margin-top: 0 !important">
      <div class="item">
        {!! \Illuminate\Mail\Markdown::parse($announcement->content) !!}
      </div>
    </div>
    @endforeach
  </div>
  <div class="actions">
    <div class="ui green ok button">
      <i class="checkmark icon"></i>
      Got it!
    </div>
  </div>
</div>

<script>$('#announcement').modal('show')</script>
@endif
