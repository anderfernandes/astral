@extends('layout.admin')

@section('title', 'Member Information')

@section('subtitle', $member->primary->fullname)

@section('icon', 'address card')

@section('content')

  <div class="ui container">

    @if($member->end->isPast())
    <div class="ui red icon message">
      <i class="exclamation circle icon"></i>
      <div class="content">
        <div class="header">
          {{ $member->primary->fullname }}'s membership expired {{ $member->end->diffInDays(now()) }}
          {{ $member->end->diffInDays(now()) == 1 ? 'day' : 'days' }} ago!
        </div>
        Ask {{ $member->firstname }} to renew their membership so that they can keep
        enjoying membership benefits and supporting {{ App\Setting::find(1)->organization }}!
      </div>
    </div>
    @endif

    <a href="{{ route('admin.members.index') }}" class="ui basic black button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="{{ route('admin.users.edit', $member->primary) }}" class="ui yellow button">
      <i class="edit icon"></i> Edit Member
    </a>
    <a href="{{ route('admin.members.create') }}" class="ui secondary button">
      <i class="ui icons">
        <i class="address card icon"></i>
        <i class="inverted corner add icon"></i>
      </i>
      Add Another Member
    </a>
    <a onclick="$('#secondary').modal('show')" class="ui black button">
      <i class="ui icons">
        <i class="address card icon"></i>
        <i class="inverted corner add icon"></i>
      </i>
      Add Secondary
    </a>
    <a href="{{ route('admin.members.edit', $member) }}" class="ui yellow button">
      <i class="edit icon"></i> Edit/Renew Membership
    </a>
    <div class="ui dropdown black button">
      <i class="copy icon"></i> Documents
      <i class="dropdown icon"></i>
      <div class="menu">
        <a href="{{ route('admin.members.receipt', $member) }}" target="_blank" class="item">
          <i class="file icon"></i>Receipt
        </a>
        <a href="{{ route('admin.members.card', $member) }}" target="_blank" class="item">
          <i class="address card icon"></i> Card
        </a>
        <a href="{{ route('admin.members.receipt', $member) }}?format=pdf" target="_blank" class="item">
          <i class="file pdf icon"></i>Receipt
        </a>
      </div>
    </div>

    <div class="ui large dividing header">
      <i class="address card icon"></i>
      <div class="content">
        # {{ $member->number }} - 
        {{ $member->primary->fullname }}
        <div class="ui black label">{{ $member->type->name }}</div>
        <div class="sub header">
          @if ($member->creator_id != 1)
          <i class="user circle icon"></i> {{ $member->creator->firstname }} |
          @endif
          <i class="pencil icon"></i>{{ $member->created_at->format('l, F j, Y \a\t g:i:s A') }}
          ({{ $member->created_at->diffForHumans() }}) |
          <i class="edit icon"></i>{{ $member->updated_at->format('l, F j, Y \a\t g:i:s A') }}
        </div>
      </div>
    </div>
    <div class="ui four column stackable grid">
      <div class="column">
        <div class="ui header">
          {{ $member->primary->address }}
          <div class="sub header">Address</div>
        </div>
        <div class="ui header">
          {{ $member->primary->email }}
          <div class="sub header">Email</div>
        </div>
      </div>
      <div class="column">
        <div class="ui header">
          {{ $member->primary->city }}
          <div class="sub header">City</div>
        </div>
        <div class="ui header">
          {{ $member->start->format('l, F j, Y') }}
          <div class="sub header">Start Date</div>
        </div>
      </div>
      <div class="column">
        <div class="ui header">
          {{ $member->primary->state }}
          <div class="sub header">State</div>
        </div>
        <div class="ui {{ $member->end->isPast() ? 'red' : '' }} header">
          {{ $member->end->format('l, F j, Y') }}
          <div class="sub header">
            Expiration Date 
            ({{ $member->end->diffInDays(now()) }} days {{ $member->end->isPast() ? 'ago' : 'left' }})
          </div>
        </div>
      </div>
      <div class="column">
        <div class="ui header">
          {{ $member->primary->zip }}
          <div class="sub header">ZIP</div>
        </div>
      </div>
    </div>

    <br />

    @if ($member->secondaries->count() == 0)
      <div class="ui icon info message">
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">No secondaries</div>
          <p>This membership has no secondaries.</p>
        </div>
      </div>
    @else
      <table class="ui very basic unstackable table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($member->secondaries as $secondary)
              <tr>
                <td>
                  <a class="ui small header" href="{{ route('admin.users.show', $secondary) }}">
                    <i class="address card outline icon"></i>
                    <div class="content">
                      {{ $secondary->fullname }}
                      <div class="sub header">
                        {{ $member->type->name }} (Secondary)
                      </div>
                    </div>
                  </a>
                </td>
                <td>
                  <div class="ui icon buttons">
                    <a href="{{ route('admin.users.edit', $secondary) }}" target="_blank" class="ui yellow button">
                      <i class="edit icon"></i>
                    </a>
                    <a href="{{ route('admin.members.card', $member) }}?index={{ $loop->index }}" target="_blank" class="ui black button">
                      <i class="address card icon"></i>
                    </a>
                  </div>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    @endif

  </div>


  <div class="ui basic modal" id="secondary">
    <div class="ui icon header">
      <i class="address card icon"></i>
      @if ($member->secondaries->count() >= $member->type->max_secondaries)
        Add Non Free Secondary
      @else
        Add Free Secondary
      @endif
    </div>
    @if ($member->secondaries->count() >= $member->type->max_secondaries)
    {!! Form::model($member, ['route' => ['admin.members.addSecondary', $member], 'class' => 'ui form', 'method' => 'PUT', 'id' =>'non-secondaries']) !!}
    <div class="content">
      <p style="text-align:center">Select all non-free secondaries below. <strong>${{ $member->type->secondary_price }} each</strong>. This will create a new sale.</p>
      <div class="field">
        {!! Form::select('secondaries', $users, null, ['placeholder' => 'Select one or more non-secondaries.', 'class' => 'ui search dropdown', 'multiple' => true, 'id' => 'secondaries']) !!}
      </div>
      <div class="ui five inverted tiny statistics">
        <div class="statistic">
          <div class="label">Subtotal</div> 
          <div class="value" id="subtotal">$ 0.00</div>
        </div> 
        <div class="statistic">
          <div class="label">Tax ({{ App\Setting::find(1)->tax }}%)</div> 
          <div class="value" id="tax">$ 0.00</div>
        </div> 
        <div class="statistic">
          <div class="label">Total</div> 
          <div class="value" id="total">$ 0.00</div>
        </div> <div class="statistic">
          <div class="label">Tendered</div> 
          <div class="value" id="tendered">$ 0.00</div>
        </div> 
        <div class="ui statistic red" ingroup="">
          <div class="label">Balance</div> 
          <div class="value" id="balance">$ 0.00</div>
        </div>
      </div>
      <br /><br />
      <div class="four fields">
        <div class="field">
          <label style="color:white">Tendered</label> 
          <div class="ui labeled tendered input">
            <div class="ui basic label">$</div> 
            <input type="text" value="0.00" id="tendered-input" name="tendered">
          </div>
        </div> 
        <div class="field">
          <label style="color:white">Change Due</label> 
          <div class="ui labeled input">
            <div class="ui basic label">$</div> 
            <input readonly="readonly" type="text" value="0.00" id="change-due-input">
          </div>
        </div> 
        <div class="field">
          <label style="color:white">Payment Method</label> 
          {!! Form::select('payment_method_id', $methods, null, ['placeholder' => 'Payment Method', 'class' => 'ui dropdown', 'id' => 'payment-method']) !!}
        </div> 
        <div class="field">
          <label style="color:white">Reference</label> 
          <div class="ui input" placeholder="Check or CC">
            <input type="text" name="reference" id="reference-input" placeholder="Check or CC" value="">
          </div>
        </div>
      </div>
      <br />
      <div class="field">
        <label style="color:white">Memo</label> 
        <textarea placeholder="Anything we should know about this sale?" name="memo" id="memo" rows="2"></textarea>
      </div>
      <br /><br />
      <div class="field">
        <input type="hidden" name="nonfree" />
        {!! Form::button('<i class="checkmark icon"></i> Add Secondary', ['type' => 'submit', 'class' => 'ui green ok inverted submit button', 'id' => 'submit-non-secondaries']) !!}
      </div>
    </div>
    {!! Form::close() !!}
    @else
    {!! Form::model($member, ['route' => ['admin.members.addSecondary', $member], 'class' => 'ui form', 'method' => 'PUT']) !!}
    <div class="content">
      <p style="text-align:center">Who do you want to make a secondary for this membership?</p>
      <div class="field">
        {!! Form::select('user_id', $users, null, ['placeholder' => 'Select one or more non-secondaries.', 'class' => 'ui search dropdown', 'multiple' => true]) !!}
      </div>
      <div class="field">
        {!! Form::button('<i class="checkmark icon"></i> Add Secondary', ['type' => 'submit', 'class' => 'ui green ok inverted button']) !!}
      </div>
    </div>
    @endif
    <div class="actions">
      <div class="ui red basic cancel inverted button">
        <i class="remove icon"></i>
        Cancel
      </div>
    </div>
  </div>
  
  <script>
    $(document).ready(function() {
      $('#secondaries').dropdown('setting', 'onChange', function(value, text, $choice) {
        const payment_method_id = parseInt($('#payment-method').val())
        const subtotal = value.length * {{ $member->type->secondary_price }}
        const tax = ({{ App\Setting::find(1)->tax }} * subtotal) / 100
        const total = subtotal + tax
        $('#subtotal').text(`$ ${subtotal.toFixed(2)}`)
        $('#tax').text(`$ ${tax.toFixed(2)}`)
        $('#total').text(`$ ${total.toFixed(2)}`)
        if (Number.isNaN(payment_method_id)) return
        if (payment_method_id != 1) {
          $('#tendered').text(`$ ${total.toFixed(2)}`)
          $('#tendered-input').val(total.toFixed(2))
        }
      })
      $('#payment-method').dropdown('setting', 'onChange', function (value, text, $choice) {
        console.log(value == 1, text)
        if (value != 1) {
          const numberOfSecondaries = $('#secondaries').dropdown('get value').length
          const subtotal = numberOfSecondaries * {{ $member->type->secondary_price }}
          const tax = ({{ App\Setting::find(1)->tax }} * subtotal) / 100
          const total = subtotal + tax
          $('#subtotal').text(`$ ${subtotal.toFixed(2)}`)
          $('#tax').text(`$ ${tax.toFixed(2)}`)
          $('#total').text(`$ ${total.toFixed(2)}`)
          $('#tendered').text(`$ ${total.toFixed(2)}`)
          $('#tendered-input').val(total.toFixed(2))
          $('.ui.labeled.tendered.input').addClass('disabled')
          $('#reference-input').focus()
          return
        }
        $('.ui.labeled.tendered.input').removeClass('disabled')
        $('#tendered').text('$ 0.00')
        $('#tendered-input').val('0.00')
        $('#change-due-input').val('0.00')
      })
      $('#tendered-input').on('input', function (event) {
        const tendered = parseFloat(event.target.value)
        $('#tendered').text(`$ ${tendered.toFixed(2)}`)
        const total = parseFloat($('#total').text().split(' ')[1])
        const balance =  (tendered - total)
        $('#balance').text(`$ ${balance > 0 ? 0..toFixed(2) : balance.toFixed(2)}`)
        const change_due = balance > 0 ? balance : 0
        $('#change-due-input').val(`$ ${change_due.toFixed(2)}`)
      })
      $('#non-secondaries').form({
        fields: {
          secondaries: 'empty',
          payment_method_id: 'empty',
          reference: 'empty'
        }
      })
      $('#submit-non-secondaries').click(function(event) {
        const tendered = parseFloat($('#tendered-input').val())
        const numberOfSecondaries = $('#secondaries').dropdown('get value').length
        const subtotal = numberOfSecondaries * {{ $member->type->secondary_price }}
        const tax = ({{ App\Setting::find(1)->tax }} * subtotal) / 100
        const total = parseFloat((subtotal + tax).toFixed(2))
        console.log(`Tendered: ${tendered} Subtotal:${subtotal} Tax: ${tax} Total: ${total}`)
        if (tendered < total) {
          event.preventDefault()
          alert(`Tendered ${tendered.toFixed(2)} is less than Total ${total.toFixed(2)}`)
          return
        }
      })
    })
  </script>

@endsection

