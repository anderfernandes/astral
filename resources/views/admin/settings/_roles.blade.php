<div class="ui tab segment" data-tab="user-roles">
  <div class="ui two column doubling grid">
    <div class="column">
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
              <div class="ui label">
                @if ($role->staff)
                  Yes
                @else
                  No
                @endif
              </div>
            </td>
            <td>
              <a href="{{ route('admin.roles.edit', $role->id) }}" class="ui basic icon button">
                <i class="edit icon"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="column">
      {!! Form::open(['route' => 'admin.roles.store', 'class' => 'ui form', 'id' => 'users']) !!}
      <div class="two fields">
        <div class="required field">
          {!! Form::label('name', 'Name') !!}
          {!! Form::text('name', null, ['placeholder' => 'Role Name']) !!}
        </div>
        <div class="required field">
          {!! Form::label('staff', 'Staff') !!}
          {!! Form::select('staff', [false => 'No', true => 'Yes'], false, ['class' => 'ui dropdown']) !!}
        </div>
      </div>
      <div class="field">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
      </div>
      <div class="field">
        {!! Form::button('<i class="plus icon"></i> Add User Role', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
