<div class="ui tab segment" data-tab="organization-types">
  <div class="ui two column doubling grid">
    <div class="column">
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
                <div class="ui label">Yes</div>
              @else
                <div class="ui label">No</div>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="column">
      {!! Form::open(['route' => 'admin.settings.addOrganizationType', 'class' => 'ui form', 'id' => 'organizations']) !!}
        <div class="two fields">
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
        </div>
        <div class="field">
          {!! Form::label('description', 'Description') !!}
          {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
        </div>
        <div class="field">
          {!! Form::button('<i class="plus icon"></i> Add Organization Type', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
        </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
