@extends('layout.admin')

@section('title', 'Logs')

@section('subtitle', Auth::user()->fullname)

@section('icon', 'clipboard')

@section('content')

  <form class="ui filter form" action="{{ route('admin.logs') }}" method="GET">
    <div class="four fields">
      <div class="field">
        <select name="type" class="ui search type dropdown">
          <option value="">All Types</option>
          @foreach ($log_types as $log_type)
            <option {{ request()->type == $log_type ? "selected" : "" }}
              value="{{ $log_type }}">{{ $log_type }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <a href="{{ route('admin.logs.clear') }}" class="ui basic red button">
          <i class="eraser icon"></i> Clear
        </a>
      </div>
    </div>
  </form>

  <div class="ui message" style="text-align: center">
    There {{ count($logs) == 1 ? "is" : "are"}}
    <strong>{{ count($logs) }} messag{{ count($logs) == 1 ? "e" : "es"}}</strong> in the log.
  </div>

  @foreach ($logs as $log)
  <div class="ui raised segment">
    <div class="ui dividing items">
      <div class="item">
        <div class="content">
          <div class="header">
            {{ $log["date"]->format('l, F j, Y \a\t g:i A') }}
            @if ($log["type"] == "error")
            <div class="ui red label"><i class="info circle icon"></i>{{ $log["type"] }}</div>
            @elseif ($log["type"] == "info")
            <div class="ui blue label"><i class="info circle icon"></i>{{ $log["type"] }}</div>
            @else
            <div class="ui label">{{ $log["type"] }}</div>
            @endif
          </div>
          <div class="meta">({{ $log["date"]->diffForHumans() }})</div>
          <div class="description">
            <div class="ui divider"></div>
            <p>{{ $log["message"] }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <script>
    $('form').change(function() { this.submit() })
  </script>

@endsection
