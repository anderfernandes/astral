<div class="ui tab segment" data-tab="grade">

  @include('admin.grades._form')

  <table class="ui very basic striped selectable celled table">
    <thead>
      <tr>
        <th>Grade Name and Description</th>
        <th>Created by</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($grades as $grade)
      <tr>
        <td>
          <h4 class="ui header">
            <i class="book icon"></i>
            <div class="content">
              {{ $grade->name }}
              <div class="sub header">{{ $grade->description }}</div>
            </div>
          </h4>
        </td>
        <td>
          <i class="user circle icon"></i> {{ $grade->creator_id == 1 ? 'system' : $grade->creator->fullname }}
        </td>
        <td>
          <div class="ui tiny buttons">
            @if(str_contains(Auth::user()->role->permissions['sales'], 'U'))
              <a href="{{ route('admin.grades.edit', $grade) }}" class="ui icon yellow button"><i class="edit icon"></i></a>
            @endif
            @if(str_contains(Auth::user()->role->permissions['sales'], 'D'))
              <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="ui icon red button"><i class="trash icon"></i></a>
              </form>
            @endif
          </div>

        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
