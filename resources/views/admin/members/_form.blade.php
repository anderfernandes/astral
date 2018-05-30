<form action="{{ isSet($member) ? route('admin.members.update', $member) : route('admin.members.store') }}" id="members" class="ui form" method="POST">
  @isset($member)
    {{ method_field('PUT') }}
  @endisset
  {{ csrf_field() }}
<div class="ui two column grid">
  <div class="column">
    <div class="required field">
      <label for="user_id">Name</label>
      <div class="ui search selection dropdown" id="name">
        <input type="hidden" name="user_id">
        <i class="dropdown icon"></i>
        <div class="default text">Select a customer</div>
        <div class="menu">
          @foreach ($users as $user)
            <div class="item" data-value="{{ $user->id }}">
              <i class="user circle icon"></i>{{ $user->fullname }} (<em>{{ $user->role->name }}</em>)
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="required field">
      <label for="member_type_id">Memebrship Type</label>
      <div class="ui search selection dropdown" id="member_type_id">
        <input type="hidden" name="member_type_id">
        <i class="dropdown icon"></i>
        <div class="default text">Select a membership type</div>
        <div class="menu">
          @foreach ($memberTypes as $memberType)
            <div class="item" data-value="{{ $memberType->id }}">
              <i class="user circle icon"></i>{{ $memberType->name }} -
              <strong>$ {{ number_format($memberType->price, 2) }}</strong>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="required two fields">
      <div class="field">
        <label for="start">Start Date</label>
        <div class="ui left icon input">
          <input type="text" name="start" id="start" placeholder="Membership starting date">
          <i class="calendar icon"></i>
        </div>
      </div>
      <div class="field">
        <label for="start">End Date</label>
        <div class="ui left icon input">
          <input type="text" name="end" id="end" placeholder="Membership ending date">
          <i class="calendar icon"></i>
        </div>
      </div>
    </div>
  </div>

  {{-- Payment Information --}}

  <div class="column">
    <div class="three fields">
      <div class="required field">
        <label for="payment_method_id">Payment Method</label>
        <div class="ui selection dropdown" id="payment_method">
          <input type="hidden" id="payment_method_id" name="payment_method_id" value="{{ old('payment_method_id') }}">
          <i class="dropdown icon"></i>
          <div class="default text">Select Payment Method</div>
          <div class="menu">
            @foreach ($paymentMethods as $paymentMethod)
            <div class="item" data-value="{{ $paymentMethod->id }}">
              <i class="{{ $paymentMethod->icon }} icon"></i> {{ $paymentMethod->name }}
            </div>
            @endforeach
          </div>
        </div>
      </div>
      <div class="field">
        <label for="required tendered">Tendered</label>
        <div class="ui labeled input">
          <div class="ui label">$ </div>
          <input type="text" id="tendered" name="tendered" value="{{ number_format(old('tendered') ?? 0, 2) }}">
        </div>
      </div>
      <div class="field">
        <label for="change_due">Change Due</label>
        <div class="ui labeled input">
          <div class="ui label">$ </div>
          <input type="text" name="change_due" id="change_due" value="{{ number_format(old('change_due') ?? 0, 2) }}" placeholder="Change Due" readonly>
        </div>
      </div>
    </div>
    <div class="field">
      <label for="reference">Reference</label>
      <input type="text" name="referece" id="reference" placeholder="Credit Card or Check reference" value="{{ old('reference') }}">
    </div>
    <div class="field">
      <label for="memo">Memo</label>
      <input type="text" placeholder="Memo" value="{{ old('memo') }}">
    </div>
  </div>
</div>
<div class="field">
  <label for="secondaries">Free Secondaries</label>
  <select name="secondaries[]" id="secondaries" multiple="" class="ui dropdown">
    <option value="">Select secondaries</option>
  </select>
</div>
<div class="field">
  <label for="paid_secondaries[]">Non-free Secondaries</label>
  <select name="paid_secondaries[]" id="paid_secondaries" multiple="" class="ui disabled dropdown">
    <option value="">Select secondaries</option>
  </select>
</div>
<br /><br />
<div class="field">
  <div class="ui buttons">
    <a href="{{ route('admin.members.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
    <div class="ui yellow right floated right labeled reset icon button">Start Over <i class="eraser icon"></i></div>
    <div class="ui positive right floated right labeled submit icon button">Save <i class="save icon"></i></div>
  </div>
</div>
<div class="ui grid">
  <div class="ui sixteen wide column" style="padding: 0 0 0 0 !important">
    <div class="ui bottom fixed sticky" style="width:100%">
      <div class="ui inverted segment" style="border-radius: 0 !important">
        <div class="five fields">
          <div class="field">
            <label for="subtotal">Subtotal</label>
            <div class="ui inverted transparent left icon input">
              <i class="dollar icon"></i>
              <input type="text" name="subtotal" id="subtotal" value="{{ number_format(0, 2) }}" placeholder="Subtotal" readonly>
            </div>
          </div>
          <div class="field">
            <label for="tax">Tax ({{ App\Setting::find(1)->tax }}%)</label>
            <div class="ui inverted transparent left icon input">
              <i class="dollar icon"></i>
              <input type="text" name="tax" id="tax" placeholder="Tax" value="{{ number_format(0, 2) }}" readonly>
            </div>
          </div>
          <div class="field">
            <label for="total">Total</label>
            <div class="ui inverted transparent left icon input">
              <i class="dollar icon"></i>
              <input type="text" name="total" id="total" value="{{ number_format(0, 2) }}" placeholder="Total" readonly>
            </div>
          </div>
          <div class="field">
            <label for="paid">Paid</label>
            <div class="ui inverted transparent left icon input">
              <i class="dollar icon"></i>
              <input type="text" id="paid" name="paid" value="{{ number_format(0, 2) }}" readonly>
            </div>
          </div>
          <div class="field">
            <label for="paid">Balance</label>
            <div class="ui inverted transparent left icon input">
              <i class="dollar icon"></i>
              <input type="text" id="balance" name="balance" value="{{ number_format(0, 2) }}" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>

<script>
  function calculateTotals() {
    var subtotal = $('#member_type_id').dropdown('get value') == "" ? 0 : $('#member_type_id').dropdown('get text').split(" ").slice(-1)
    subtotal = parseFloat(subtotal)
    var paidSecondaries = $('#paid_secondaries').dropdown('get value').length * 20
    subtotal = subtotal + paidSecondaries
    subtotalString = subtotal.toFixed(2)
    var tax = (({{ App\Setting::find(1)->tax }}/100) * subtotal).toFixed(2)
    tax = parseFloat(tax)
    var taxString = tax.toFixed(2)
    total = subtotal + tax
    var totalString = total.toFixed(2)
    $('#subtotal').val(subtotalString)
    $('#tax').val(taxString)
    $('#total').val(totalString)
  }

  $('#member_type_id').change(calculateTotals)

  {{-- Remove selected user from the list of possible secondaries --}}
  $(document).ready(function() {
    $('#name').dropdown({
      onChange: function(value, text, $choice) {
        $('#member_type_id').dropdown('clear')
        $('#secondaries').dropdown('clear')
        $('#paid_secondaries').dropdown('clear')
        $('#secondaries').html('')
        fetch(`/api/customers?primary=${value}`)
          .then(response => response.json())
          .then(customers => {
            customers.map(customer => {
              $('#secondaries').append(`<option value="${customer.id}">${customer.name} (${customer.role})</option>`)
              //$('#paid_secondaries').append(`<option value="${customer.id}">${customer.name} (${customer.role})</option>`)
            })
          })
          .then(() => {
            <?php

            if (old('secondaries') != null)
            {
              foreach (old('secondaries') as $secondary) {
                echo "$('#secondaries').dropdown('set selected', $secondary) \n ";
              }
            }
            ?>
          })
      } // end of dropdown onChange
    }) // end of dropdown
  }) // end of function


  $('#tendered').keyup(function() {
    var totalString = document.querySelector('#total').value
    var total = parseFloat(totalString)
    var balanceString = document.querySelector('#balance').value
    var balance = parseFloat(balanceString)
    var tendered = document.querySelector('#tendered').value
    var tenderedString = parseFloat(tendered)
    balance = (tendered - total).toFixed(2)
    balance = balance <= 0 ? balance : (0).toFixed(2)
    $('#balance').val(balance)

    changeDue = (tendered - total).toFixed(2)
    changeDue = changeDue >= 0 ? changeDue : (0).toFixed(2)

    $('#change_due').val(changeDue)
  })

  $('#start').flatpickr({ defaultDate: '{{ old('start') ?? 'today' }}', dateFormat: 'l, F j, Y' });

  $('#member_type_id').dropdown('set selected', {{ old('member_type_id') }})
  $('#payment_method').dropdown('set selected', {{ old('payment_method_id') }})

  {{-- Getting membership duration and filling in atomatically --}}
  $('#member_type_id').change(function() {
    var membership_type_id = $(this).dropdown('get value')
    fetch(`/api/membership-type/${membership_type_id}`)
      .then(response => response.json())
      .then(membership_type => {
        $('#secondaries').dropdown('clear')
        $('#paid_secondaries').dropdown('clear')
        var start = document.querySelector('#start').value
        var end = moment(start, 'dddd, MMMM D, YYYY').add(membership_type.duration, 'days').format('dddd, MMMM D, YYYY')
        $('#end').flatpickr({ defaultDate: end, dateFormat: 'l, F j, Y'})
        $($('.ui.multiple.selection.dropdown')[0]).dropdown({maxSelections: membership_type.max_secondaries})
      })
      .then(() => { calculateTotals() })
  })

  {{-- Free Secondaries --}}
  $('#secondaries').change(function() {
    var membership_type_id = $('#member_type_id').dropdown('get value')
    fetch(`/api/membership-type/${membership_type_id}`)
    .then(response => response.json())
    .then(membership_type => {
      if ($('#secondaries').dropdown('get value').length >= membership_type.max_secondaries) {
        $('#paid_secondaries').dropdown('clear')
        $('#paid_secondaries').removeClass('disabled')
        $($('.ui.multiple.selection.dropdown')[1]).removeClass('disabled')
        var user_id = $('#name').dropdown('get value')
        fetch(`/api/customers?primary=${user_id}`)
          .then(response => response.json())
          .then(customers => {
            customers.map(customer => {
              {{-- Only add values that are not selected in the free secondaries dropdown --}}
              if (!$('#secondaries').dropdown('get values').includes(customer.id.toString()))
                $('#paid_secondaries').append(`<option value="${customer.id}">${customer.name} (${customer.role})</option>`)
            })
          })
      } else {
        $('#paid_secondaries').dropdown('clear')
        $('#paid_secondaries').html('')
        $($('.ui.multiple.selection.dropdown')[1]).addClass('disabled')
      }
    })
  })

  {{-- Update totals when non-free secondaries change --}}
  $('#paid_secondaries').change(function() {
    calculateTotals()
  })

  $(document).ready(function() {
    calculateTotals()
    $('#name').dropdown('get value') != null ? $('#name').dropdown('set selected', {{ old('user_id') }}) : null
  })

  $('#members').form({
    on: 'blur',
    inline: true,
    fields: {

    }
  })

</script>

<style>
  input#subtotal, input#tax, input#total, input#paid, input#balance {font-weight: bold !important}
</style>
