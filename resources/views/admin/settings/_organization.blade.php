<div class="ui tab segment" data-tab="organization-types">

  {!! Form::open(['route' => 'admin.settings.addOrganizationType', 'class' => 'ui form', 'id' => 'organizations']) !!}
    <div class="four fields">
      <div class="field">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['placeholder' => 'Organization Type']) !!}
      </div>
      <div class="field">
        {!! Form::label('taxable', 'Taxable') !!}
        {!! Form::select('taxable',
          [1 => 'Yes', 0 => 'No'],
          null,
          ['placeholder' => 'Taxable?', 'class' => 'ui dropdown']) !!}
      </div>
      <div class="field">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
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
        <th>Available Types</th>
        <th>Number of Organizations</th>
        <th>Taxable</th>
      </tr>
    </thead>
    <tbody>
      @foreach($organizationTypes as $organizationType)
      <tr>
        <td>
          <h4 class="ui header">
            <i class="university icon"></i>
            <div class="content">
              {{ $organizationType->name }}
              <div class="sub header">{{ $organizationType->description }}</div>
            </div>
          </h4>
        </td>
        <td>
          {{ App\Organization::where('type_id', $organizationType->id)->count() }}
        </td>
        <td>
          @if ($organizationType->taxable)
            <div class="ui black label">Yes</div>
          @else
            <div class="ui black label">No</div>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
