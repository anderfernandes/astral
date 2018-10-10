<form action="{{ isSet($memberType) ? route('admin.member-types.update', $memberType) : route('admin.member-types.store') }}" id="member_types" class="ui form" method="POST">
  @isset($memberType)
    {{ method_field('PUT') }}
  @endisset
  {{ csrf_field() }}
  <div class="two required fields">
    <div class="field">
      <label for="name">Name</label>
      <input type="text" name="name" value="{{ $memberType->name ?? old('name') }}" placeholder="Name of the membership type">
    </div>
    <div class="field">
      <label for="name">Description</label>
      <input type="text" name="description" value="{{ $memberType->description ?? old('description') }}" placeholder="Duration of the membership type">
    </div>
  </div>
  <div class="four required fields">
    <div class="field">
      <label for="price">Price</label>
      <div class="ui labeled input">
        <div class="ui basic label">$</div>
        <input type="text" name="price" value="{{ $memberType->price ?? old('price') }}" placeholder="Price of the memebrship">
      </div>
    </div>
    <div class="field">
      <label for="Duration">Duration</label>
      <input type="text" name="duration" value="{{ $memberType->duration ?? old('duration') }}" placeholder="Duration in days of the membership">
    </div>
    <div class="field">
      <label for="max_secondaries">Maximum Number of Free Secondaries</label>
      <input type="text" name="max_secondaries" value="{{ $memberType->max_secondaries ?? old('max_secondaries') }}" placeholder="Max number of free secondaries">
    </div>
    <div class="field">
      <label for="secondary_price">Non-free Secondry Price</label>
      <div class="ui labeled input">
        <div class="ui basic label">$</div>
        <input type="text" name="secondary_price" value="{{ $memberType->secondary_price ?? old('secondary_price') }}" placeholder="Price of non-free secondaries">
      </div>
    </div>
  </div>
  <div class="field">
    <a href="{{ route('admin.settings.index') }}#member-types" class="ui black basic button"><i class="left chevron icon"></i> Back</a>
    <div class="ui positive right labeled submit icon button">Save <i class="save icon"></i></div>
    <div class="ui yellow right labeled clear icon button">Start Over <i class="eraser icon"></i></div>
  </div>
</form>

<script>

  $('#member_types').form({
    on: 'blur',
    inline: true,
    fields: {
      name:            ['empty', 'minLength[3]'],
      description:     ['empty', 'minLength[3]'],
      duration:        ['empty', 'integer'],
      max_secondaries: ['empty', 'integer'],
      secondary_price: ['empty', 'number'],
    }
  })

</script>
