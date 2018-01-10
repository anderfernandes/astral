@extends('layout.admin')

@section('title', 'Reports')

@section ('subtitle', 'Get Reports')

@section ('icon', 'file text')

@section('content')


  <div onclick="$('#closeout').modal('show')" class="ui button black"><i class="file text icon outline"></i> Closeout</div>
  <div onclick="$('#transaction-detail').modal('show')" class="ui button black"><i class="file text icon"></i> Transaction Detail</div>

  <div class="ui basic modal" id="closeout">
    <div class="ui icon header">
      <i class="file type icon"></i>
      Closeout Report
    </div>
    <div class="ui form">
      <div class="content">
        <p>Select the payment user:</p>
      </div>
      <div class="field">
        {!! Form::select('closeout_user', $users, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'closeout-user']) !!}
      </div>
      <div class="content">
        <p>Select the payment range:</p>
      </div>
      <div class="two fields">
        <div class="field">
            <div class="ui left icon input">
              {!! Form::text('closeout_start', null, ['placeholder' => 'Start Date and Time', 'id' => 'closeout-start']) !!}
            <i class="calendar icon"></i>
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            {!! Form::text('closeout_end', null, ['placeholder' => 'End Date and Time', 'id' =>'closeout-end']) !!}
            <i class="calendar icon"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="actions">
    <div class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      Cancel
    </div>
    <div id="closeout-submit" class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      OK
    </div>
  </div>
  </div>

  <div class="ui basic modal" id="transaction-detail">
    <div class="ui icon header">
      <i class="file type icon"></i>
      Transaction Detail Report
    </div>
    <div class="ui form">
      <div class="content">
        <p>Select the payment user:</p>
      </div>
      <div class="field">
        {!! Form::select('transaction_detail_user', $users, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'transaction-detail-user']) !!}
      </div>
      <div class="content">
        <p>Select the payment range:</p>
      </div>
      <div class="two fields">
        <div class="field">
            <div class="ui left icon input">
              {!! Form::text('transaction_detail_start', null, ['placeholder' => 'Start Date and Time', 'id' => 'transaction-detail-start']) !!}
            <i class="calendar icon"></i>
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            {!! Form::text('transaction_detail_end', null, ['placeholder' => 'End Date and Time', 'id' =>'transaction-detail-end']) !!}
            <i class="calendar icon"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="actions">
    <div class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      Cancel
    </div>
    <div id="transaction-detail-submit" class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      OK
    </div>
  </div>
  </div>

</div>

  <script>
    $('#closeout-start').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:0, defaultMin:0});
    $('#closeout-end').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K'});

    $('#transaction-detail-start').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:0, defaultMin:0});
    $('#transaction-detail-end').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K'});

    $('#closeout-submit').click(function() {
      var user = document.querySelector('#closeout-user').value
      var start = document.querySelector('#closeout-start').value
      start = moment(start).format('Y-M-D')
      window.open('/admin/reports/closeout/' + user + '/' + start, '_blank')
    })

    $('#transaction-detail-submit').click(function() {
      var user = document.querySelector('#closeout-user').value
      var start = document.querySelector('#closeout-start').value
      start = moment(start).format('Y-M-D')
      window.open('/admin/reports/transaction-detail/' + user + '/' + start, '_blank')
    })

  </script>

@endsection
