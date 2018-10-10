@extends('layout.ticket')

@section('title', "Ticket #{$ticket->id}")

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

  <div class="ui icon right floated buttons" style="margin-bottom:5rem">
    <a href="{{ route('admin.sales.receipt', $sale)}}?format=pdf" target="_blank" class="ui basic black button"><i class="file pdf outline icon"></i></a>
    <div onclick="window.print()" class="ui black button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui red button"><i class="close icon"></i></div>
  </div>

  @include('admin.tickets._ticket')

@endsection
