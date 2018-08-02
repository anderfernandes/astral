<div class="ui tab segment" data-tab="event-types">
  @include('admin.event-types._form', ['eventType' => null])
  <table class="ui very basic striped selectable celled table">
    <thead>
      <tr>
        <th>Event Types</th>
      </tr>
    </thead>
    <tbody>
      @foreach($eventTypes as $eventType)
      <tr>
        <td>
          <div class="ui inverted segment" style="background-color: {{ $eventType->color }}">
            <a href="{{ route('admin.event-types.edit', $eventType) }}" class="ui yellow right corner label"><i class="edit icon"></i></a>
            <h4 class="ui inverted header" style="margin-top: 0">
              <div class="content">
                {{ $eventType->name }}
                <div class="sub header">{{ $eventType->description }}</div>
              </div>
            </h4>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
