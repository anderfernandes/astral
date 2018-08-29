<div class="ui tab segment" data-tab="organization-types">

  @include('admin.organization-types._form')

  <table class="ui very basic striped selectable celled table">
    <thead>
      <tr>
        <th>Available Types</th>
        <th>Number of Organizations</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($organizationTypes as $organizationType)
      <tr>
        <td>
          <h4 class="ui header">
            <i class="university icon"></i>
            <div class="content">
              {{ $organizationType->name }}
              @if ($organizationType->taxable)
                <div class="ui black label">Taxable</div>
              @else
                <div class="ui black label">Non-taxable</div>
              @endif
              <div class="sub header">
                {{ $organizationType->description }}
              </div>
            </div>
          </h4>
        </td>
        <td>
          {{ App\Organization::where('type_id', $organizationType->id)->count() }}
        </td>
        <td>
            <div class="ui icon buttons">
              <a href="{{ route('admin.organization-types.edit', $organizationType) }}" class="ui yellow button">
                <i class="edit icon"></i>
              </a>
            </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
