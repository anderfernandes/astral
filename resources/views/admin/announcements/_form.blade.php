<form action="{{
  isSet($announcement)
  ? route('admin.announcements.update', $announcement)
  : route('admin.announcements.store')
}}" id="announcements" class="ui form" method="POST">
  @isset($announcement)
    {{ method_field('PUT') }}
  @endisset
  {{ csrf_field() }}
  <div class="two fields">
    <div class="required field">
      <label for="start">Start</label>
      <div class="ui left icon input">
        <input placeholder="Announcement Star Date and Time" name="start" type="text" readonly="readonly">
        <i class="calendar icon"></i>
      </div>
    </div>
    <div class="required field">
      <label for="end">End</label>
      <div class="ui left icon input">
        <input placeholder="Announcement End Date and Time" name="end" type="text" readonly="readonly">
        <i class="calendar icon"></i>
      </div>
    </div>
  </div>
  <div class="three fields">
    <div class="required field">
      <label for="title">Title</label>
      <input type="text" name="title" placeholder="Title of the Announcement" value="{{ isSet($announcement) ? $announcement->title : old('title') }}">
    </div>
    <div class="required field">
      <label for="title">Type</label>
      <select name="type" class="ui announcement type dropdown"
        value="{{ isSet($announcement) ? $announcement->public : old('type') }}">
        <option value="blue">blue</option>
        <option value="yellow">yellow</option>
        <option value="green">green</option>
        <option value="red">red</option>
      </select>
    </div>
    <div class="required field">
      <label for="title">Public</label>
      <select name="public" class="ui announcement public dropdown"
        value="{{ isSet($announcement) ? $announcement->public : old('public') }}">
        <option value="1">Yes</option>
        <option value="0" selected>No</option>
      </select>
    </div>
  </div>
  <div class="required field">
    <label for="content">Content</label>
    <textarea name="content" id="content" cols="30" rows="10" placeholder="Enter the text of the announcement"></textarea>
  </div>
  <div class="field">
    <div class="ui positive right floated right labeled submit icon button">Save <i class="save icon"></i></div>
  </div>
</form>

<script>

  $('#announcements').form({
    on: 'blur',
    inline: true,
    fields: {
      start : ['empty'],
      end   : ['empty'],
      title : ['empty', 'minLength[3]'],
      description: ['empty', 'minLength[5]'],
    }
  })

  $('[name="start"]').flatpickr({
    enableTime: true,
    minDate: 'today',
    defaultDate: '{{ isSet($announcement) ? $announcement->start->format('l, F j, Y g:i A')
                                          : now()->format('l, F j, Y g:i A') }}',
    dateFormat: 'l, F j, Y h:i K',
    minuteIncrement: 15
  })

  $('[name="end"]').flatpickr({
    enableTime: true,
    minDate: 'today',
    defaultDate: '{{ isSet($announcement) ? $announcement->end->format('l, F j, Y g:i A')
                                          : now()->addDay()->endOfDay()->format('l, F j, Y g:i A') }}',
    dateFormat: 'l, F j, Y h:i K',
    minuteIncrement: 15
  })

  window.simplemde = new SimpleMDE({
    element: document.querySelector('#content'),
    toolbar: ['bold', 'italic', 'strikethrough', '|', 'unordered-list', 'ordered-list', '|', 'link', 'image', 'table', 'horizontal-rule', '|', 'preview', 'guide'],
  })


  simplemde.value(`{!! isSet($announcement) ? \Illuminate\Mail\Markdown::parse($announcement->content) : \Illuminate\Mail\Markdown::parse(old('content')) !!}`)

  document.querySelector('[name="start"]').onchange = function() {
    document.querySelector('[name="end"]').value = moment(this.value).add(1, 'day').endOf('day').format('dddd, MMMM D, YYYY h:mm:ss A')
  }

  @isSet($announcement)
    $('.ui.announcement.type.dropdown').dropdown('set selected', "{{ $announcement->type }}")
    $('.ui.announcement.public.dropdown').dropdown('set selected', "{{ $announcement->public }}")
  @endisset

</script>
