<div class="ui large modal" id="{{ $id }}">
  <i class="close icon"></i>
  <div class="header">
    <i class="icons">
      <i class="{{ $icon }} icon"></i>
      @if (isSet($type))
        <i class="{{ $type }} corner icon"></i>
      @endif
    </i>
     {{ $title }}
  </div>
  <div class="content">
    <div class="description" style="width: inherit !important">
      {{ $content }}
    </div>
  </div>
  <br><br>
</div>
