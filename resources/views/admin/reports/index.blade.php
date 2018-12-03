@extends('layout.admin')

@section('title', 'Reports')

@section ('subtitle', 'Get Reports')

@section ('icon', 'file text')

@section('content')

  <div class="ui top attached tabular menu">
    <div class="active item" data-tab="cashier"><i class="inbox icon"></i> Cashier</div>
    <div class="item" data-tab="attendance"><i class="ticket icon"></i> Attendance</div>
    <div class="item" data-tab="royalties"><i class="money icon"></i> Royalties</div>
    <div class="item" data-tab="membership"><i class="address card icon"></i> Membership</div>
    <div class="item" data-tab="product"><i class="box icon"></i> Product</div>
    <div class="item" data-tab="system"><i class="setting icon"></i> System</div>
  </div>

  {{-- Cashier Reports Tab --}}
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

  {{-- Royalties Reports Tab --}}
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

  {{-- Membership Reports Tab --}}
  <div class="ui bottom attached tab segment" data-tab="membership">
    <h3 class="ui dividing header">
      <i class="address card icon"></i>
      <div class="content">
        Membership
        <div class="sub header">These reports contain information on memberships</div>
      </div>
    </h3>
    <div class="ui four doubling stackable cards">
      <!--- New Members Report Card --->
      <div class="card">
        <div class="content">
          <div class="header">New Members Report</div>
          <div class="description">This report displays a list of new members by membership start date and time range</div><br />
          <div class="ui form">
            <div class="field">
              <label for="royalty_start">Range:</label>
                <div class="ui left icon input">
                  {!! Form::text('new_member_start', null, ['placeholder' => 'Start Date and Time', 'id' => 'new-member-start']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                {!! Form::text('new_member_end', null, ['placeholder' => 'End Date and Time', 'id' =>'new-member-end']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
          </div>
        </div>
        <div id="new-member-submit" class="ui bottom attached black button">Get New Members Report <i class="right chevron icon"></i></div>
      </div>

    </div>
  </div>

  {{-- System Reports --}}
  <div class="ui bottom attached tab segment" data-tab="system">
    <h3 class="ui dividing header">
      <i class="address card icon"></i>
      <div class="content">
        System
        <div class="sub header">These reports contain information on your instance of Astral</div>
      </div>
    </h3>
    <div class="ui four doubling stackable cards">
      <div class="card">
        <div class="content">
          <div class="header">Overall Report</div>
          <div class="description">This report displays overall information on the data processed by Astral so far</div>
        </div>
        <a href="{{ route('admin.reports.overall') }}" target="_blank" class="ui bottom attached black button">Get Overall Report <i class="right chevron icon"></i></a>
      </div>
    </div>
  </div>

  {{-- Attendance --}}
  <div class="ui bottom attached tab segment" data-tab="attendance">
    <h3 class="ui dividing header">
      <i class="ticket icon"></i>
      <div class="content">
        Attendance
        <div class="sub header">These reports contain information on attendance on a given date/time range for all sales marked as "complete".</div>
      </div>
    </h3>
    <div class="ui four doubling cards">
      <!--- By Organization Report Card --->
      <div class="card">
        <div class="content">
          <div class="header">By Organization</div>
          <div class="description">This report shows attendance data on a particular or all organizations during a given date/time range.</div><br />
          <div class="ui form">
            <div class="field">
              <label for="closeout_user">Select organization:</label>
              {!! Form::select('attendance_organization', $organizations, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'attendance_organization']) !!}
            </div>
            <div class="field">
              <label for="closeout_start">Select date and time range:</label>
                <div class="ui left icon input">
                  {!! Form::text('closeout_start', null, ['placeholder' => 'Start Date and Time', 'id' => 'attendance_organization_start']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                {!! Form::text('closeout_end', null, ['placeholder' => 'End Date and Time', 'id' =>'attendance_organization_end']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                {!! Form::checkbox('charts', 0, false, ['id' => 'attendance_organization_charts', 'disabled' => true]) !!}
                <label for="attendance_organization_charts">Show charts</label>
              </div>
            </div>
          </div>
        </div>
        <div onclick="getReportLink('attendance_organization')" class="ui bottom attached black button">Get Organization Attendance Report <i class="right chevron icon"></i></div>
      </div>
      <!--- By Organization Type Report Card --->
      <div class="card">
        <div class="content">
          <div class="header">By Organization Type</div>
          <div class="description">This report shows attendance data on a particular or all organizations types during a given date/time range.</div><br />
          <div class="ui form">
            <div class="field">
              <label for="closeout_user">Select organization:</label>
              {!! Form::select('attendance_organization_type', $organization_types, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'attendance_organization_type']) !!}
            </div>
            <div class="field">
              <label for="closeout_start">Select date and time range:</label>
                <div class="ui left icon input">
                  {!! Form::text('closeout_start', null, ['placeholder' => 'Start Date and Time', 'id' => 'attendance_organization_type_start']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                {!! Form::text('closeout_end', null, ['placeholder' => 'End Date and Time', 'id' =>'attendance_organization_type_end']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                {!! Form::checkbox('charts', 0, false, ['id' => 'attendance_organization_type_charts', 'disabled' => true]) !!}
                <label for="attendance_organization_types_charts">Show charts</label>
              </div>
            </div>
          </div>
        </div>
        <div onclick="getReportLink('attendance_organization_type')" class="ui bottom attached black button">Get Organization Attendance Report <i class="right chevron icon"></i></div>
      </div>
      <!--- By Event Type Report Card --->
      <div class="card">
        <div class="content">
          <div class="header">By Event Type</div>
          <div class="description">This report shows attendance data on a particular or all event types during a given date/time range.</div><br />
          <div class="ui form">
            <div class="field">
              <label for="closeout_user">Select the event type:</label>
              {!! Form::select('attendance_event_type', $event_types, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'attendance_event_type']) !!}
            </div>
            <div class="field">
              <label for="closeout_start">Select date and time range:</label>
                <div class="ui left icon input">
                  {!! Form::text('attendance_event_type_start', null, ['placeholder' => 'Start Date and Time', 'id' => 'attendance_event_type_start']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                {!! Form::text('attendance_event_type_end', null, ['placeholder' => 'End Date and Time', 'id' =>'attendance_event_type_end']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                {!! Form::checkbox('charts', 0, false, ['id' => 'attendance_ticket_type_charts', 'disabled' => true]) !!}
                <label for="attendance_event_types_charts">Show charts</label>
              </div>
            </div>
          </div>
        </div>
        <div onclick="getReportLink('attendance_event_type')" class="ui bottom attached black button">Get Event Type Attendance Report <i class="right chevron icon"></i></div>
      </div>
      <!--- By Ticket Type Report Card --->
      <div class="card">
        <div class="content">
          <div class="header">By Ticket Type</div>
          <div class="description">This reports shows revenue and attendanc on an ticket type during a given date/time range.</div><br />
          <div class="ui form">
            <div class="field">
              <label for="closeout_user">Select the ticket type:</label>
              {!! Form::select('attendance_ticket_type', $ticket_types, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'attendance_ticket_type']) !!}
            </div>
            <div class="field">
              <label for="closeout_start">Select the payment range:</label>
                <div class="ui left icon input">
                  {!! Form::text('attendance_ticket_type_start', null, ['placeholder' => 'Start Date and Time', 'id' => 'attendance_ticket_type_start']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                {!! Form::text('attendance_ticket_type_end', null, ['placeholder' => 'End Date and Time', 'id' =>'attendance_ticket_type_end']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                {!! Form::checkbox('charts', 0, false, ['id' => 'attendance_event_type_charts', 'disabled' => true]) !!}
                <label for="attendance_event_types_charts">Show charts</label>
              </div>
            </div>
          </div>
        </div>
        <div onclick="getReportLink('attendance_ticket_type')" class="ui bottom attached black button">Get Ticket Type Attendance Report <i class="right chevron icon"></i></div>
      </div>
    </div>
  </div>

  {{-- Product --}}
  <div class="ui bottom attached tab segment" data-tab="product">
    <h3 class="ui dividing header">
      <i class="box icon"></i>
      <div class="content">
        Products
        <div class="sub header">These reports contain information on products</div>
      </div>
    </h3>
    <div class="ui four doubling cards">
      {{-- Product Reports --}}
      <div class="card">
        <div class="content">
          <div class="header">Product Report</div>
          <div class="description">This report shows data on sold products during a given date/time range.</div><br />
          <div class="ui form">
            <div class="field">
              <label for="closeout_user">Select product:</label>
              {!! Form::select('products', $products, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'products']) !!}
            </div>
            <div class="field">
              <label for="closeout_start">Select date and time range:</label>
              <div class="ui left icon input">
                {!! Form::text('products_start', null, ['placeholder' => 'Start Date and Time', 'id' => 'products_start']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                {!! Form::text('closeout_end', null, ['placeholder' => 'End Date and Time', 'id' =>'products_end']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                {!! Form::checkbox('charts', 0, false, ['id' => 'products_charts', 'disabled' => true]) !!}
                <label for="products_charts">Show charts</label>
              </div>
            </div>
          </div>
        </div>
        <div onclick="getProductReportLink('products')" class="ui bottom attached black button">Get Report <i class="right chevron icon"></i></div>
      </div>
      {{-- Product Type Report --}}
      <div class="card">
        <div class="content">
          <div class="header">Product Type Report</div>
          <div class="description">This report shows data on sold products by type during a given date/time range.</div><br />
          <div class="ui form">
            <div class="field">
              <label for="closeout_user">Select product:</label>
              {!! Form::select('product_type', $productTypes, null, ['class' => 'ui fluid selection search scrolling dropdown', 'id' => 'product_type']) !!}
            </div>
            <div class="field">
              <label for="closeout_start">Select date and time range:</label>
                <div class="ui left icon input">
                  {!! Form::text('product_type_start', null, ['placeholder' => 'Start Date and Time', 'id' => 'product_type_start']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                {!! Form::text('product_type_end', null, ['placeholder' => 'End Date and Time', 'id' =>'product_type_end']) !!}
                <i class="calendar icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                {!! Form::checkbox('charts', 0, false, ['id' => 'product_type_charts', 'disabled' => true]) !!}
                <label for="product_type_charts">Show charts</label>
              </div>
            </div>
          </div>
        </div>
        <div onclick="getProductReportLink('product_type')" class="ui bottom attached black button">Get Report <i class="right chevron icon"></i></div>
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

    $('#attendance_organization_start').flatpickr({ maxDate: 'today', dateFormat: 'l, F j, Y' });
    $('#attendance_organization_end').flatpickr({ maxDate: 'today', defaultDate: 'today', dateFormat: 'l, F j, Y' });

    $('#attendance_organization_type_start').flatpickr({ maxDate: 'today', dateFormat: 'l, F j, Y' });
    $('#attendance_organization_type_end').flatpickr({ maxDate: 'today', defaultDate: 'today', dateFormat: 'l, F j, Y' });

    $('#attendance_event_type_start').flatpickr({ maxDate: 'today', dateFormat: 'l, F j, Y' });
    $('#attendance_event_type_end').flatpickr({ maxDate: 'today', defaultDate: 'today', dateFormat: 'l, F j, Y' });

    $('#attendance_ticket_type_start').flatpickr({ maxDate: 'today', dateFormat: 'l, F j, Y' });
    $('#attendance_ticket_type_end').flatpickr({ maxDate: 'today', defaultDate: 'today', dateFormat: 'l, F j, Y' });

    $('#transaction-detail-start').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:0, defaultMinute:0});
    $('#transaction-detail-end').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:23, defaultMinute:59});

    $('#royalty-start').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:0, defaultMinute:0});
    $('#royalty-end').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:23, defaultMinute:59});

    $('#new-member-start').flatpickr({enableTime:true, dateFormat: 'l, F j, Y h:i K', defaultHour:0, defaultMinute:0, maxDate: 'today'});
    $('#new-member-end').flatpickr({enableTime:true, defaultDate: 'today', dateFormat: 'l, F j, Y h:i K', defaultHour:23, defaultMinute:59, maxDate: 'today'});

    $('#products_start').flatpickr({enableTime:false, dateFormat: 'l, F j, Y', defaultHour:0, defaultMinute:0, maxDate: 'today'});
    $('#products_end').flatpickr({enableTime:false, defaultDate: 'today', dateFormat: 'l, F j, Y', defaultHour:23, defaultMinute:59, maxDate: 'today'});

    $('#product_type_start').flatpickr({enableTime:false, dateFormat: 'l, F j, Y', defaultHour:0, defaultMinute:0, maxDate: 'today'});
    $('#product_type_end').flatpickr({enableTime:false, defaultDate: 'today', dateFormat: 'l, F j, Y', defaultHour:23, defaultMinute:59, maxDate: 'today'});


    function getReportLink(type) {
      var data = document.querySelector(`#${type}`).value
      var start = document.querySelector(`#${type}_start`).value
      var end = document.querySelector(`#${type}_end`).value
      var charts = document.querySelector(`#${type}_charts`).checked
      start = moment(start, 'dddd, MMMM D, YYYY').startOf('day').format('X')
      end = moment(end, 'dddd, MMMM D, YYYY').endOf('day').format('X')
      window.open(`/admin/reports/attendance?type=${type}&data=${data}&start=${start}&end=${end}&charts=${charts}`, '_blank')
    }

    function getProductReportLink(type) {
      var data = document.querySelector(`#${type}`).value
      var start = document.querySelector(`#${type}_start`).value
      var end = document.querySelector(`#${type}_end`).value
      var charts = document.querySelector(`#${type}_charts`).checked
      start = moment(start, 'dddd, MMMM D, YYYY').startOf('day').format('X')
      end = moment(end, 'dddd, MMMM D, YYYY').endOf('day').format('X')
      window.open(`/admin/reports/product?type=${type}&data=${data}&start=${start}&end=${end}&charts=${charts}`, '_blank')
    }

    $('#closeout-submit').click(function() {
      var user = document.querySelector('#closeout-user').value
      var start = document.querySelector('#closeout-start').value
      var end = document.querySelector('#closeout-end').value
      start = moment(start, 'dddd, MMMM D, YYYY h:mm A').format('X')
      end = moment(end, 'dddd, MMMM D, YYYY h:mm A').format('X')
      window.open('/admin/reports/closeout?user=' + user + '&start=' + start + '&end=' + end, '_blank')
    })

    $('#transaction-detail-submit').click(function() {
      var user = document.querySelector('#transaction-detail-user').value
      var start = document.querySelector('#transaction-detail-start').value
      var end = document.querySelector('#transaction-detail-end').value
      start = moment(start, 'dddd, MMMM D, YYYY h:mm A').format('X')
      end = moment(end, 'dddd, MMMM D, YYYY h:mm A').format('X')
      window.open('/admin/reports/transactionDetail?user=' + user + '&start=' + start + '&end=' + end, '_blank')
    })

    $('#royalty-submit').click(function() {
      var show = document.querySelector('#royalty-show').value
      var start = document.querySelector('#royalty-start').value
      var end = document.querySelector('#royalty-end').value
      var free = document.querySelector('#free').checked ? 1 : 0
      start = moment(start, 'dddd, MMM D, YYYY h:mm A').format('X')
      end = moment(end, 'dddd, MMM D, YYYY h:mm A').format('X')

      window.open('/admin/reports/royalty?show=' + show + '&free=' + free + '&start=' + start + '&end=' + end, '_blank')
    })

    $('#new-member-submit').click(function() {
      var start = document.querySelector('#new-member-start').value
      var end = document.querySelector('#new-member-end').value
      start = moment(start, 'dddd, MMM D, YYYY h:mm A').format('X')
      end = moment(end, 'dddd, MMM D, YYYY h:mm A').format('X')
      window.open('/admin/reports/newMembers?start=' + start + '&end=' + end, '_blank')
    })

  </script>

@endsection
