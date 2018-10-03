<form action="{{
  isSet($grade)
  ? route('admin.grades.update', $grade)
  : route('admin.grades.store')
}}" id="grades" class="ui form" method="POST">
@if (isSet($grade))
  {{ method_field('PUT') }}
@endif
{{ csrf_field() }}
<div class="two fields">
  <div class="required field">
    <label for="name">Name</label>
    <input type="text" name="name" placeholder="Grade name" value="{{ isSet($grade->name) ? $grade->name : old('name') }}">
  </div>
  <div class="required field">
    <label for="description">Description</label>
    <input type="text" name="description" placeholder="Describe the grade" value="{{ isSet($grade->description) ? $grade->description : old('description') }}">
  </div>
</div>
<div class="field">
  <div class="ui positive right floated right labeled submit icon button">Save <i class="save icon"></i></div>
</div>
</form>

<script>
  $('#grades').form({
    on: 'blur',
    inline: true,
    fields: {
      name: ['empty', 'minLength[3]'],
      description: ['empty', 'minLength[3]'],
    }
  })
</script>
