<div class="ui tab segment" data-tab="user-roles">
  {!! Form::open(['route' => 'admin.roles.store', 'class' => 'ui form', 'id' => 'users']) !!}
  <div class="four fields">
    <div class="required field">
      {!! Form::label('name', 'Name') !!}
      {!! Form::text('name', null, ['placeholder' => 'Role Name']) !!}
    </div>
    <div class="required field">
      {!! Form::label('staff', 'Staff') !!}
      {!! Form::select('staff', [false => 'No', true => 'Yes'], false, ['class' => 'ui dropdown']) !!}
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
        <th>Roles</th>
        <th>Staff</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($roles as $role)
      <tr>
        <td>
          <h4 class="ui header">
            <i class="user icon"></i>
            <div class="content">
              {{ $role->name }}
              <div class="sub header">{{ $role->description }}</div>
            </div>
          </h4>
        </td>
        <td>
          <div class="ui black label">
            @if ($role->staff)
              Yes
            @else
              No
            @endif
          </div>
        </td>
        <td>
          <a href="{{ route('admin.roles.edit', $role->id) }}" class="ui tiny yellow icon button">
            <i class="edit icon"></i>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
