<div class="ui tab segment" data-tab="member-types">

  @include('admin.member-types._form')

  <table class="ui very basic striped selectable celled table">
    <thead>
      <tr>
        <th>Membership</th>
        <th>Price</th>
        <th>Duration</th>
        <th>Max Free Secondaries</th>
        <th>Non-free Secondary Price </th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($memberTypes as $memberType)
      <tr>
        <td>
          <h4 class="ui header">
            <i class="address card outline icon"></i>
            <div class="content">
              {{ $memberType->name }}
              <div class="sub header">{{ $memberType->description }}</div>
            </div>
          </h4>
        </td>
        <td>
          $ {{ $memberType->price }}
        </td>
        <td>
          {{ $memberType->duration }} days
        </td>
        <td>
          {{ $memberType->max_secondaries }}
        </td>
        <td>
          $ {{ number_format($memberType->secondary_price, 2) }}
        </td>
        <td>
          <a href="{{ route('admin.member-types.edit', $memberType) }}" class="ui tiny yellow icon button">
            <i class="edit icon"></i>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
