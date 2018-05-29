<form action="{{ isSet($member) ? route('admin.members.update', $member) : route('admin.members.store') }}" id="members" class="ui form" method="POST">
  @isset($member)
    {{ method_field('PUT') }}
  @endisset
  {{ csrf_field() }}
<div class="ui two column grid">
  <div class="column">
    <div class="field">
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
    <div class="field">
      <label for="member_type_id">Memebrship Type</label>
      <div class="ui search selection dropdown" id="member_type_id">
        <input type="hidden" name="member_type_id">
        <i class="dropdown icon"></i>
        <div class="default text">Select a customer</div>
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
    <div class="two fields">
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
  <div class="column">
    <div class="three fields">
      <div class="field">
        <label for="payment_method_id">Payment Method</label>
        <div class="ui fluid selection dropdown">
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
        <label for="tendered">Tendered</label>
        <div class="ui labeled input">
          <div class="ui label">$ </div>
          <input type="text" id="tendered" name="tendered" value="{{ number_format(0, 2) }}">
        </div>
      </div>
      <div class="field">
        <label for="change_due">Change Due</label>
        <div class="ui labeled input">
          <div class="ui label">$ </div>
          <input type="text" name="change_due" id="change_due" value="{{ number_format(0, 2) }}" placeholder="Change Due" readonly>
        </div>
      </div>
    </div>
    <div class="field">
      <label for="reference">Reference</label>
      <input type="text" name="referece" id="reference" placeholder="Credit Card or Check reference">
    </div>
    <div class="field">
      <label for="memo">Memo</label>
      <input type="text" placeholder="Memo">
    </div>
  </div>
</div>
<div class="field">
  <label for="secondaries">Secondaries</label>
  <select name="secondaries[]" id="secondaries" multiple="" class="ui dropdown">
    <option value="">Select secondaries</option>
  </select>
</div>
<br /><br />
<div class="field">
  <div class="ui buttons">
    <a href="{{ route('admin.members.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
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
    var price = $('#member_type_id').dropdown('get value') == "" ? 0 : $('#member_type_id').dropdown('get text').split(" ").slice(-1)
    price = parseFloat(price)
    priceString = price.toFixed(2)
    var tax = (({{ App\Setting::find(1)->tax }}/100) * price).toFixed(2)
    tax = parseFloat(tax)
    var taxString = tax.toFixed(2)
    total = price + tax
    var totalString = total.toFixed(2)
    $('#subtotal').val(priceString)
    $('#tax').val(taxString)
    $('#total').val(totalString)
  }

  $('#member_type_id').change(calculateTotals)

  {{-- Remove selected user from the list of possible secondaries --}}
  $(document).ready(function() {
    $('#name').dropdown({
      onChange: function(value, text, $choice) {
        $('#secondaries').dropdown('clear')
        $('#secondaries').html('')
        fetch(`/api/customers?primary=${value}`)
          .then(response => response.json())
          .then(customers => {

            customers.map(customer => {
              $('#secondaries').append(`<option value="${customer.id}">${customer.name} (${customer.role})</option>`)
            })
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

  $('#start').flatpickr({ defaultDate: 'today', dateFormat: 'l, F j, Y' });
  $('#end').flatpickr({ defaultDate: moment().add(365, 'days').format('dddd, MMMM D, YYYY'), dateFormat: 'l, F j, Y'})

  function setMembershipEndDate() {
    var start = document.querySelector('#start').value
    var end = moment(start, 'dddd, MMMM D, YYYY').add(365, 'days').format('dddd, MMMM D, YYYY')
    $('#end').flatpickr({ defaultDate: end, dateFormat: 'l, F j, Y'})
  }

  $('#start').change(setMembershipEndDate)
  $(document).ready(setMembershipEndDate)
  $(document).ready(calculateTotals)

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
