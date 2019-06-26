<div class="ui tab segment active" data-tab="general">
  {!! Form::model($setting, ['route' => ['admin.settings.update', $setting], 'class' => 'ui form', 'id' => 'general', 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
    <div class="field">
      <div class="ui buttons">
        {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui green right labeled icon button']) !!}
      </div>
    </div>
    <div class="four fields">
      <div class="field">
        {!! Form::label('organization', 'Organization Name') !!}
        {!! Form::text('organization', null, ['placeholder' => 'Organization Name', 'data-validate' => 'organization']) !!}
      </div>
      <div class="field">
        {!! Form::label('astc', 'Member of ASTC?') !!}
        {!! Form::select('astc', [true => 'Yes', false => 'No'], null, ['placeholder' => 'Select an Organization Type', 'class' => 'ui search dropdown']) !!}
      </div>
      <div class="field">
        {!! Form::label('seats', 'Number of Seats') !!}
        {!! Form::number('seats', null, ['placeholder' => 'Number of Seats']) !!}
      </div>
      <div class="field">
        {!! Form::label('tax', 'Tax (%)') !!}
        <div class="ui right labeled input">
          {!! Form::number('tax', null, ['placeholder' => 'Tax %', 'step' => '0.01']) !!}
          <div class="ui basic label">%</div>
        </div>
      </div>
    </div>
    <div class="three fields">
      <div class="field">
        {!! Form::label('address', 'Address') !!}
        {!! Form::text('address', null, ['placeholder' => 'Full address']) !!}
      </div>
      <div class="field">
        {!! Form::label('phone', 'Phone') !!}
        {!! Form::tel('phone', null, ['placeholder' => 'Phone']) !!}
      </div>
      <div class="field">
        {!! Form::label('fax', 'Fax') !!}
        {!! Form::tel('fax', null, ['placeholder' => 'Fax']) !!}
      </div>
    </div>
    <div class="two fields">
      <div class="field">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['placeholder' => 'Email']) !!}
      </div>
      <div class="field">
        {!! Form::label('website', 'Website') !!}
        <div class="ui labeled input">
          <div class="ui basic label">http://</div>
          {!! Form::text('website', null, ['placeholder' => 'Enter organization\'s website']) !!}
        </div>
      </div>
    </div>
    <div class="two fields">
      <div class="field">
        <label for="cover">Logo</label>
        <div class="ui action input">
          <input type="text" id="logo-upload" readonly placeholder="Upload a logo">
          <input type="file" name="logo" accept=".jpg,.jpeg,.png" style="display:none !important">
          <div class="ui black logo upload button">
            Choose Logo...
          </div>
        </div>
      </div>
      <div class="field">
        <div class="field">
          <label for="cover">Cover</label>
          <div class="ui action input">
            <input type="text" id="cover-upload" readonly placeholder="Upload a wallpaper sized image">
            <input type="file" name="cover" accept=".jpg,.jpeg,.png" style="display:none !important">
            <div class="ui black cover upload button">
              Choose Cover...
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="ui two column grid">
      <div class="column">
        <div class="ui basic segment">
          <img src="{{ $setting->logo == '/logo.png' ? $setting->logo : Storage::url($setting->logo) }}" class="ui small centered image">
        </div>
      </div>
      <div class="column">
        <div class="ui basic segment">
          <img src="{{ $setting->cover == '/cover.jpg' ? $setting->cover : Storage::url($setting->cover) }}" class="ui small centered image">
        </div>
      </div>
    </div>
    <div class="field">
      {!! Form::label('membership_text', 'Membership Receipt Text') !!}
      {!! Form::textarea('membership_text', null, ['placeholder' => 'Membership information that will be displayed in the membership receipt']) !!}
    </div>
    <div class="field">
      {!! Form::label('confirmation_text', 'Confirmation Text') !!}
      {!! Form::textarea('confirmation_text', null, ['placeholder' => 'Membership information that will be displayed in the membership receipt']) !!}
    </div>
    <div class="field">
      {!! Form::label('invoice_text', 'Invoice Text') !!}
      {!! Form::textarea('invoice_text', null, ['placeholder' => 'Membership information that will be displayed in the membership receipt']) !!}
    </div>
    <div class="four fields">
      <div class="field">
        <label>Mebership Card Width</label>
        <div class="ui right labeled input">
          {!! Form::text('membership_card_width', null, [
            'placeholder'   => 'Membership Card Width', 
            'data-validate' => 'membership_card_width', 
            'type'          => 'number',
            'min'           => '0.00']) !!}
          <div class="ui basic label">inches</div>
        </div>
      </div>
      <div class="field">
        <label>Membership Card Height</label>
        <div class="ui right labeled input">
          {!! Form::number('membership_card_height', null, [
            'placeholder'   => 'Membership Card Height', 
            'data-validate' => 'membership_card_height', 
            'min'           => '0.00',
            'step'          => '0.01']) 
          !!}
          <div class="ui basic label">inches</div>
        </div>
      </div>
      <div class="field">
        <label>Membership Number Length</label>
        <div class="ui right labeled input">
          {!! Form::number('membership_number_length', null, [
            'placeholder'   => 'Membership Card Width', 
            'data-validate' => 'memebership_number_length',
            'min'           => strlen((string)App\Member::all()->last()->id),
            'step'          => '0.01']) 
          !!}
          <div class="ui basic label">numbers</div>
        </div>
      </div>
      <div class="field">
        <label>UPC-A Barcode in Membership Cards</label>
        {!! Form::select('membership_card_barcode', [ 
          0 => 'No', 
          1 => 'Yes'
          ], null, ['class' => 'ui dropdown']) !!}
      </div>
    </div>
    <div class="four fields">
      <div class="field">
        <label>Cashier Customer Dropdown</label>
        {!! Form::select('cashier_customer_dropdown', [ 
          0 => 'Show All Customers', 
          1 => 'Show Members Only'
          ], null, ['class' => 'ui dropdown']) !!}
      </div>
    </div>
    <div class="field">
      <div class="ui buttons">
        {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui green right labeled icon button']) !!}
      </div>
    </div>

  {!! Form::close() !!}
</div>

<script>
{{-- Logo --}}
$('#logo-upload, .ui.black.logo.upload.button').on('click', function(e) {
  $('input:file[name="logo"]', $(e.target).parents()).click()
})

$('[name="logo"]').on('change', function(e) {
  var name = e.target.files[0].name
  $('input:text#logo-upload', $(e.target).parent()).val(name)
})

{{-- Cover --}}
$('#cover-upload, .ui.black.cover.upload.button').on('click', function(e) {
  $('input:file[name="cover"]', $(e.target).parents()).click()
})

$('[name="cover"]').on('change', function(e) {
  var name = e.target.files[0].name
  $('input:text#cover-upload', $(e.target).parent()).val(name)
})
</script>
