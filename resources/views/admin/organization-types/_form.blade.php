<form action="{{ isSet($organizationType) ?
  route('admin.organization-types.update', $organizationType) : route('admin.organization-types.store') }}"
  class="ui organization types form" method="POST">
  @isSet($organizationType)
    {{ method_field('PUT') }}
  @endisset
  {{ csrf_field() }}
  <div class="two fields">
    <div class="field">
      <label for="name">Name</label>
      <input type="text" name="name" placeholder="Organization Type"
        value="{{ isSet($organizationType) ? $organizationType->name : old('name') }}">
    </div>
    <div class="field">
      <label for="taxable">Taxable?</label>
      <select name="taxable" class="ui taxable dropdown"
        value="{{ isSet($organizationType) ? $organizationType->taxable : old('taxable') }}">
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>
    </div>
  </div>
  <div class="field">
    <label for="description">Description</label>
    <input type="text" name="description" placeholder="Enter a description for the organization type"
      value="{{ isSet($organizationType) ? $organizationType->description : old('description') }}">
  </div>
  <div class="field">
    <a href="{{ route('admin.settings.index') }}#organization-types" class="ui black basic button"><i class="left chevron icon"></i> Back</a>
    <div class="ui positive right labeled submit icon button">Save <i class="save icon"></i></div>
    <div class="ui yellow right labeled clear icon button">Start Over <i class="eraser icon"></i></div>
  </div>
</form>

<script>

  $('.ui.organization.types.form').form({

  })

  @isSet($organizationType)
    $('.ui.taxable.dropdown').dropdown('set selected', "{{ $organizationType->taxable }}")
  @endisset

</script>
