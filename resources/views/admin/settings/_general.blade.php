<div class="ui tab segment active" data-tab="general">
  {!! Form::model($setting, ['route' => ['admin.settings.update', $setting], 'class' => 'ui form', 'id' => 'general', 'method' => 'PUT']) !!}
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
        {!! Form::label('logo', 'Logo (URL)') !!}
        {!! Form::text('logo', null, ['placeholder' => 'URL to a PNG or JPEG']) !!}
        <br /><br />
      </div>
      <div class="field">
        {!! Form::label('cover', 'Cover (URL)') !!}
        {!! Form::text('cover', null, ['placeholder' => 'URL to a PNG or JPEG']) !!}
        <br /><br />
      </div>
    </div>
    <div class="ui two column grid">
      <div class="column">
        <div class="ui basic segment"><img src="{{ '/'.App\Setting::find(1)->logo }}" alt="" class="ui small image"></div>
      </div>
      <div class="column">
        <div class="ui basic segment"><img src="{{ '/'.App\Setting::find(1)->cover }}" alt="" class="ui medium image"></div>
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
    <div class="field">
      <div class="ui buttons">
        {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui green right labeled icon button']) !!}
      </div>
    </div>
  {!! Form::close() !!}
</div>
