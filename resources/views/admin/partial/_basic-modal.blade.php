{{-- Modal --}}
<div class="ui basic modal" id="{{ $id }}">
  <div class="ui icon header">
    <i class="{{ $icon }} icon"></i>
    {!! $title !!}
  </div>
  <div class="content">
    <p>{!! $subtitle !!}</p>
  </div>
  <div class="actions">
    @if (isSet($actions))
      {!! $actions !!}
    @else
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      Gotcha!!!
    </div>
    @endif
  </div>
</div>
