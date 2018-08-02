<div class="ui tab segment" data-tab="bulletin">
  {!! Form::open(['route' => 'admin.categories.store', 'class' => 'ui form', 'id' => 'bulletin']) !!}
  <div class="three fields">
    <div class="required field">
      {!! Form::label('name', 'Name') !!}
      {!! Form::text('name', null, ['placeholder' => 'Membership Type Name']) !!}
    </div>
    <div class="required field">
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
        <th>Category Name and Description</th>
        <th>Created by</th>
      </tr>
    </thead>
    <tbody>
      @foreach($categories as $category)
      <tr>
        <td>
          <h4 class="ui header">
            <i class="tag icon"></i>
            <div class="content">
              {{ $category->name }}
              <div class="sub header">{{ $category->description }}</div>
            </div>
          </h4>
        </td>
        <td>
          {{ $category->creator->fullname }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
