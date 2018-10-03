<div class="ui tab segment" data-tab="show-types">
  @include('admin.show-types._form')
  <table class="ui very basic striped selectable celled table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Active?</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($showTypes as $showType)
      <tr>
        <td>
          <div class="ui small header">
            {{ $showType->name }}
            <div class="sub header">
              {{ $showType->description }}
            </div>
          </div>
        </td>
        <td>
          <div class="ui {{ $showType->active ? "green" : "red" }} label">
            {{ $showType->active ? "Yes" : "No" }}
          </div>
        </td>
        <td>
          <div class="ui small icon buttons">
            <a href="{{ route('admin.show-types.edit', $showType) }}" class="ui yellow button"><i class="edit icon"></i></a>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
