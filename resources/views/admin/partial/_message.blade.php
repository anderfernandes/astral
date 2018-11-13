@if (Session::has('success'))

  {{-- Modal --}}
  <div class="ui basic modal">
    <div class="ui icon header">
      <i class="thumbs up icon"></i>
      Success, {{ Auth::user()->firstname }}!
    </div>
    <div class="content">
      <p>{!! Session::get('success') !!}</p>
    </div>
    <div class="actions">
      <div class="ui green ok inverted button">
        <i class="checkmark icon"></i>
        Gotcha!!!
      </div>
    </div>
  </div>

  <script>$('.ui.basic.modal').modal('show')</script>

  <?php Session::forget('success') ?>

@endif

@if (Session::has('warning'))

  {{-- Modal --}}
  <div class="ui basic modal">
    <div class="ui icon header">
      <i class="warning circle icon"></i>
      Something went wrong, {{ Auth::user()->firstname }}...
    </div>
    <div class="content">
      <p>{!! Session::get('warning') !!}</p>
    </div>
    <div class="actions">
      <div class="ui yellow ok inverted button">
        <i class="checkmark icon"></i>
        Gotcha!!!
      </div>
    </div>
  </div>

  <script>$('.ui.basic.modal').modal('show')</script>

  <?php Session::forget('success') ?>

@endif

@if (Session::has('info'))

  {{-- Modal --}}
  <div class="ui basic modal">
    <div class="ui icon header">
      <i class="info circle icon"></i>
      Hey, {{ Auth::user()->firstname }}!
    </div>
    <div class="content">
      <p>{!! Session::get('info') !!}</p>
    </div>
    <div class="actions">
      <div class="ui blue ok inverted button">
        <i class="checkmark icon"></i>
        Gotcha!
      </div>
    </div>
  </div>

  <script>$('.ui.basic.modal').modal('show')</script>

  <?php Session::forget('info') ?>

@endif

@if (count($errors) > 0)

  <div class="ui basic modal">
    <div class="ui icon header">
      <i class="exclamation circle icon"></i>
      {{ $errors->count() == 1 ? "There's 1 error:" : "There are {$errors->count()} errors:" }}
    </div>
    <div class="content">
      <ul class="list">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    <div class="actions">
      <div class="ui red ok inverted button">
        <i class="checkmark icon"></i>
        Gotcha, I'll fix that!
      </div>
    </div>
  </div>

  <script>$('.ui.basic.modal').modal('show')</script>

  {{--
  <div class="ui error icon message">
    <i class="warning circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        @if (count($errors) == 1)
          There is {{ count($errors) }} error:
        @else
          There are {{ count($errors) }} errors:
        @endif
      </div>
      <ul class="list">
        @foreach ($errors->all() as $error)
    			<li>{{ $error }}</li>
    		@endforeach
      </ul>
    </div>
  </div>
  --}}

@endif
