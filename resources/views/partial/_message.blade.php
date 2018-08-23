@if (Session::has('success'))
  <div class="ui success icon message">
    <i class="info circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        Success!
      </div>
      <p>{!! Session::get('success') !!}</p>
    </div>
  </div>
@endif

@if (Session::has('warning'))
  <div class="ui success icon message">
    <i class="warning circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        Something went wrong...
      </div>
      <p>{!! Session::get('warning') !!}</p>
    </div>
  </div>
@endif

@if (Session::has('info'))
  <div class="ui info icon message">
    <i class="info circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        Hey, you!
      </div>
      <p>{!! Session::get('info') !!}</p>
    </div>
  </div>
@endif

@if (count($errors) > 0)
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
@endif
