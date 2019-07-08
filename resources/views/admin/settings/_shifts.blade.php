<div class="ui tab segment" data-tab="shifts">
  {!! Form::open(['route' => 'admin.positions.store', 'class' => 'ui form', 'id' => 'positions']) !!}
  <div class="three fields">
    <div class="required field">
      {!! Form::label('name', 'Name') !!}
      {!! Form::text('name', null, ['placeholder' => 'Position Name']) !!}
    </div>
    <div class="required field">
      {!! Form::label('description', 'Description') !!}
      {!! Form::text('description', null, ['placeholder' => 'Describe this organization position']) !!}
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
        <th>Position Name and Description</th>
        <th>Created by</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($positions as $position)
      <tr>
        <td>
          <h4 class="ui header">
            <i class="user icon"></i>
            <div class="content">
              {{ $position->name }}
              <div class="sub header">{{ $position->description }}</div>
            </div>
          </h4>
        </td>
        <td>
          <i class="user circle icon"></i>
          {{ $position->creator_id == 1 ? "System" : $position->creator->firstname }}
        </td>
        <td>
        <a href="{{ route('admin.positions.edit', $position) }}" class="ui yellow labeled icon button">
          <i class="edit icon"></i>
          Edit
        </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
