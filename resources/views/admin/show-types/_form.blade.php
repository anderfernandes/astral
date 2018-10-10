<form action="{{
  isset($showType)
  ? route('admin.show-types.update', $showType)
  : route('admin.show-types.store')
}}" class="ui show types form" method="POST">
@isset($showType)
  {{ method_field('PUT') }}
@endisset
{{ csrf_field() }}
<div class="two fields">
  <div class="field">
    <label for="name">Name</label>
    <input type="text" name="name" placeholder="Show Name"
      value="{{ isset($showType) ? $showType->name : old('name') }}">
  </div>
  <div class="field">
    <label for="active">Active?</label>
    <select name="active" name="active" class="ui show type dropdown">
      <option value="">Select One</option>
      <option value="1">Yes</option>
      <option value="0">No</option>
    </select>
  </div>
</div>
<div class="field">
  <div class="field">
    <label for="description">Description</label>
    <input type="text" name="description" placeholder="Show Description"
      value="{{ isset($showType) ? $showType->description : old('description') }}">
  </div>
</div>
<div class="field">
  <div class="ui positive right floated right labeled submit icon button">
    Save <i class="save icon"></i>
  </div>
</div>
</form>

<script>
  $('.ui.show.types.form').form({
    on: 'blur',
    inline: true,
    fields: {
      name: ['empty', 'minLength[3]'],
      description: ['empty', 'minLength[3]']
    }
  })

  $('.ui.show.type.dropdown').dropdown('set selected', '{{ isset($showType) ? $showType->active : old('active') }}')
</script>
