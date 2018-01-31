@extends('layout.admin')

@section('title', 'Reports')

@section ('subtitle', 'Get Reports')

@section ('icon', 'file text')

@section('content')

  <div class="ui top attached tabular menu">
    <div class="active item" data-tab="cashier"><i class="inbox icon"></i> Cashier</div>
    <div class="item" data-tab="royalties"><i class="money icon"></i> Royalties</div>
  </div>

  <!-- Cashier Reports Tab -->
  <div class="ui bottom attached active tab segment" data-tab="cashier">
    <h3 class="ui dividing header">
      <i class="inbox icon"></i>
      <div class="content">
        Cashier
        <div class="sub header">These reports contain information on payments on a given date/time range</div>
      </div>
    </h3>
    <div class="ui four doubling stackable cards">
      <!--- Closeout Report Card --->
      <div class="card">
        <div class="content">
          <div class="header">Closeout Report</div>
          <div class="description">This report displays the total of money a cashier made during a given date/time range.</div><br />
          <div class="ui form">
            <div class="field">
              <label for="closeout_user">Select the payment user:</label>
              {!! Form::select('closeout_user', $users, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'closeout-user']) !!}
            </div>
            <div class="field">
              <label for="closeout_start">Select the payment range:</label>
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
        <div id="closeout-submit" class="ui bottom attached black button">Get Closeout Report <i class="right chevron icon"></i></div>
      </div>
      <!--- Transaction Detail Card --->
      <div class="card">
        <div class="content">
          <div class="header">Transaction Detail Report</div>
          <div class="description">This report lists every transaction a cashier made during a given date/time range.</div><br />
          <div class="ui form">
            <div class="field">
              <label for="transaction_detail_user">Select the payment user:</label>
              {!! Form::select('transaction_detail_user', $users, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'transaction-detail-user']) !!}
            </div>
            <div class="field">
              <label for="transaction_detail_start">Select the payment range:</label>
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
        <div id="transaction-detail-submit" class="ui bottom attached black button">Transaction Detail <i class="right chevron icon"></i></div>
      </div>
    </div>
  </div>

  <!-- Royalties Reports Tab -->
  <div class="ui bottom attached tab segment" data-tab="royalties">
    <h3 class="ui dividing header">
      <i class="money icon"></i>
      <div class="content">
        Royalties
        <div class="sub header">These reports contain information on show attendance and revenue</div>
      </div>
    </h3>
    <div class="ui four doubling stackable cards">
      <!--- Closeout Report Card --->
      <div class="card">
        <div class="content">
          <div class="header">Royalty Report</div>
          <div class="description">This report displays the attendance and revenue of a show during a given date/time range.</div><br />
          <div class="ui form">
            <div class="field">
              <label for="closeout_user">Select show:</label>
              {!! Form::select('royalty_show', $shows, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'royalty-show']) !!}
            </div>
            <div class="field">
              <label for="royalty_start">Select the payment range:</label>
                <div class="ui left icon input">
                  {!! Form::text('royalty_start', null, ['placeholder' => 'Start Date and Time', 'id' => 'royalty-start']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                {!! Form::text('royalty_end', null, ['placeholder' => 'End Date and Time', 'id' =>'royalty-end']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                {!! Form::checkbox('free', 0, false, ['id' => 'free']) !!}
                <label for="free">Show free tickets</label>
              </div>
            </div>
          </div>
        </div>
        <div id="royalty-submit" class="ui bottom attached black button">Get Royalty Report <i class="right chevron icon"></i></div>
      </div>

    </div>
  </div>


  <script>

    $('.menu .item').tab({ history: true });

    $('#closeout-start').change(function() {
      document.querySelector('#closeout-end').value = moment(this.value, 'dddd, MMMM D, YYYY h:mm A').add(23, 'hours').add(59, 'minutes').format('dddd, MMMM D, YYYY h:mm A');
    })

    $('#transaction-detail-start').change(function() {
      document.querySelector('#transaction-detail-end').value = moment(this.value, 'dddd, MMMM D, YYYY h:mm A').add(23, 'hours').add(59, 'minutes').format('dddd, MMMM D, YYYY h:mm A');
    })

    $('#closeout-start').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:0, defaultMinute:0});
    $('#closeout-end').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:23, defaultMinute:59});

    $('#transaction-detail-start').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:0, defaultMinute:0});
    $('#transaction-detail-end').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:23, defaultMinute:59});

    $('#royalty-start').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:0, defaultMinute:0});
    $('#royalty-end').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:23, defaultMinute:59});

    $('#closeout-submit').click(function() {
      var user = document.querySelector('#closeout-user').value
      var start = document.querySelector('#closeout-start').value
      start = moment(start, 'dddd, MMMM D, YYYY h:mm A').format('Y-M-D')
      window.open('/admin/reports/closeout/' + user + '/' + start, '_blank')
    })

    $('#transaction-detail-submit').click(function() {
      var user = document.querySelector('#transaction-detail-user').value
      var start = document.querySelector('#transaction-detail-start').value
      start = moment(start, 'dddd, MMMM D, YYYY h:mm A').format('Y-M-D')
      window.open('/admin/reports/transaction-detail/' + user + '/' + start, '_blank')
    })

    $('#royalty-submit').click(function() {
      var show = document.querySelector('#royalty-show').value
      var start = document.querySelector('#royalty-start').value
      var end = document.querySelector('#royalty-end').value
      var free = document.querySelector('#free').checked
      start = moment(start, 'dddd, MMM D, YYYY h:mm A').format('X')
      end = moment(end, 'dddd, MMM D, YYYY h:mm A').format('X')

      window.open('/admin/reports/royalty?show=' + show + '&free=' + free + '&start=' + start + '&end=' + end, '_blank')
    })

  </script>

@endsection
