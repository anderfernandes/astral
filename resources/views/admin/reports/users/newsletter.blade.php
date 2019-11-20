@extends('layout.report')

@section('title', 'Users Newsletter Report')

@section('content')

  <style>
    @media print {
      .ui.icon.buttons {
        display: none !important;
      }
      p, h4.ui.header, table, thead, tbody, ul, li, h4.ui.header .sub.header {
        font-size: 0.78rem !important;
      }
    }
  </style>

  <div class="ui icon right floated buttons" style="margin-bottom:4rem">
    <div onclick="window.print()" class="ui primary button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui secondary button"><i class="close icon"></i></div>
  </div>

  <img src="{{ asset(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <h2 class="ui center aligned header" style="margin-top:8px">
    <div class="content">Users Newsletter Report</div>
    <div class="sub header">Ran by {{ Auth::user()->fullname }} <br> on {{ Date::now()->format('l, F j, Y \a\t g:i A') }}</div>
  </h2>

  <p>
    Here {{ $users->count() === 1 ? 'is': 'are' }} the {{ $users->count() }} 
    {{ $users->count() === 1 ? 'user': 'users' }} who signed up for newsletters:
  </p>

  <table class="ui very basic table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Organization</th>
        <th>Role</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->fullname }}</td>
        <td>{{ $user->organization_id == 1 ? 'N/A' : $user->organization->name }}</td>
        <td>
          <div class="ui black label">{{ $user->role->name }}</div>
        </td>
        <td>
          <a style="color:black" href="mailto:{{ $user->email }}">
            {{ $user->email }}
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection