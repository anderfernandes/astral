<div class="ui large modal" id="{{ $id }}">
  <i class="close icon"></i>
  <div class="ui header">
    <i class="icons">
      <i class="{{ $icon }} icon"></i>
      @if (isSet($type))
        <i class="{{ $type }} corner icon"></i>
      @endif
    </i>
    <div class="content">
      {{ $title }}
      <div class="sub header">{{ $subtitle ?? '' }}</div>
    </div>
  </div>
  <div class="content">
    <div class="description" style="width: inherit !important">
      {{ $content }}
    </div>
  </div>
  <br><br>
</div>
