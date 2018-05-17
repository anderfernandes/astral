<div class="ui tab segment" data-tab="member-types">
  <div class="ui two column doubling grid">
    <div class="column">
      <table class="ui very basic striped selectable celled table">
        <thead>
          <tr>
            <th>Membership</th>
            <th>Price</th>
            <th>Duration</th>
            <th>Max Secondaries</th>
          </tr>
        </thead>
        <tbody>
          @foreach($memberTypes as $memberType)
          <tr>
            <td>
              <h4 class="ui header">
                <i class="address card outline icon"></i>
                <div class="content">
                  {{ $memberType->name }}
                  <div class="sub header">{{ $memberType->description }}</div>
                </div>
              </h4>
            </td>
            <td>
              $ {{ $memberType->price }}
            </td>
            <td>
              {{ $memberType->duration }} days
            </td>
            <td>
              {{ $memberType->max_secondaries }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="column">
      {!! Form::open(['route' => 'admin.settings.addMemberType', 'class' => 'ui form', 'id' => 'memberships']) !!}
      <div class="required field">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['placeholder' => 'Membership Type Name']) !!}
      </div>
      <div class="required field">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
      </div>
      <div class="three required fields">
        <div class="field">
          {!! Form::label('price', 'Price') !!}
          <div class="ui labeled input">
            <div class="ui label">$</div>
            {!! Form::text('price', null, ['placeholder' => 'How much is this membership going to cost?']) !!}
          </div>
        </div>
        <div class="field">
          {!! Form::label('duration', 'Duration') !!}
          <div class="ui right labeled input">
            {!! Form::text('duration', null, ['placeholder' => 'Enter the duration in days']) !!}
            <div class="ui label">days</div>
          </div>
        </div>
        <div class="field">
          {!! Form::label('max_secondaries', 'Maximum Number of Secondaries') !!}
          {!! Form::text('max_secondaries', null, ['placeholder' => 'Limit of secondaries for a membership']) !!}
        </div>
      </div>
      <div class="field">
        {!! Form::button('<i class="plus icon"></i> Add Member Type', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
