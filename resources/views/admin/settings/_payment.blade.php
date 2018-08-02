<div class="ui tab segment" data-tab="payment-methods">
  {!! Form::open(['route' => 'admin.settings.addPaymentMethod', 'class' => 'ui form', 'id' => 'payment_methods']) !!}
    <div class="three fields">
      <div class="field">
        {!! Form::label('name', 'Payment Method Name') !!}
        {!! Form::text('name', null, ['placeholder' => 'Payment Method name']) !!}
      </div>
      <div class="field">
        {!! Form::label('taxable', 'Icon') !!}
        {!! Form::text('icon', null, ['placeholder' => 'Icon class name']) !!}
      </div>
      <div class="field">
        {!! Form::label('type', 'Type') !!}
        {!! Form::select('type',
          [
            'cash'        => 'Cash',
            'card'        => 'Card',
            'check'       => 'Check',
            'money order' => 'Money Order',
            'other'       => 'Other',
          ], 'card', ['placeholder' => 'Taxable?', 'class' => 'ui dropdown']) !!}
      </div>
    </div>
    <div class="two fields">
      <div class="field">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['placeholder' => 'Describe this payment method']) !!}
      </div>
      <div class="field">
        <label for="">&nbsp;</label>
        {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui green right labeled icon button']) !!}
      </div>
    </div>
  {!! Form::close() !!}
  <table class="ui very basic striped selectable celled table">
    <thead>
      <tr>
        <th>Available Payment Methods</th>
        <th>Type</th>
      </tr>
    </thead>
    <tbody>
      @foreach($paymentMethods as $paymentMethod)
      <tr>
        <td>
          <h4 class="ui header">
            <i class="{{ $paymentMethod->icon }} icon"></i>
            <div class="content">
              {{ $paymentMethod->name }}
              <div class="sub header">{{ $paymentMethod->description }}</div>
            </div>
          </h4>
        </td>
        <td><div class="ui black label">{{ $paymentMethod->type }}</div></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
