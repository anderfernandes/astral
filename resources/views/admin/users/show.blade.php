@extends('layout.admin')

@section('title', 'User Information')

@section('subtitle', $user->fullname)

@section('icon', 'user')

@section('content')

  <div class="ui container">

    <a href="{{ route('admin.users.index') }}" class="ui basic black button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="javascript:$('#edit-user').modal('show')" class="ui yellow button">
      <i class="edit icon"></i> Edit User
    </a>
    <a href="{{ route('admin.users.create') }}" class="ui secondary button">
      <i class="add user icon"></i> Add Another User
    </a>
    @if(str_contains(Auth::user()->role->permissions['users'], "D"))
      <div class="ui red button" onclick="$('#delete-user').modal('toggle')">
        <i class="trash icon"></i> Delete User
      </div>
    @endif

    <div class="ui large dividing header">
      <i class="user circle icon"></i>
      <div class="content">
        {{ $user->fullname }}
        @if ($user->staff) <i style="display:inline-block" class="star icon"></i> @endif
        @if ($user->newsletter) <i class="newspaper outline icon"></i> @endif
        <div class="ui black label" style="margin-left:0">{{ $user->role->name }}</div>
        @if ($user->organization_id != 1)
        <a href="{{ route('admin.organizations.show', $user->organization) }}" target="_blank" class="ui black label" style="margin-left:0">
          {{ $user->organization->name }}
        </a>
        @endif
        <div class="ui black label" style="margin-left:0">
          {{ $pastSales->count() + $futureSales->count() }}
          {{ $pastSales->count() + $futureSales->count() == 1 ? 'visit' : 'visits'}}
        </div>
        @if ($user->active)
        <div class="ui green label">active</div>
        @else
        <div class="ui red label">inactive</div>
        @endif
        <div class="sub header">
          {{-- Display creator only if it is a no user --}}
          @if ($user->creator_id == 1)
            <i class="pencil icon"></i>
            {{ $user->created_at->format('l, F j, Y \a\t g:i:s A') }} ({{ $user->created_at->diffForHumans() }})
          @else
            <i class="user circle icon"></i> {{ $user->creator->fullname }}
            {{ $user->created_at->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($user->created_at)->diffForHumans()}})
          @endif
        </div>
      </div>
    </div>
    <div class="ui three column stackable grid">
      <div class="column">
        <h3 class="ui header">
          {{ $user->address }}
          <div class="sub header">Address</div>
        </h3>
        <h3 class="ui header">
          {{ $user->country }}
          <div class="sub header">
            Country
          </div>
        </h3>
        <h3 class="ui header">
          {{ $user->phone }}
          <div class="sub header">
            Phone
          </div>
        </h3>
      </div>
      <div class="column">
        <h3 class="ui header">
          {{ $user->city }}
          <div class="sub header">
            City
          </div>
        </h3>
        <h3 class="ui header">
          {{ $user->zip }}
          <div class="sub header">
            ZIP
          </div>
        </h3>
        @if ($user->fax)
        <h3 class="ui header">
          {{ $user->fax }}
          <div class="sub header">
            Fax
          </div>
        </h3>
        @endif
      </div>
      <div class="column">
        <h3 class="ui header">
          {{ $user->state }}
          <div class="sub header">
            State
          </div>
        </h3>
        <h3 class="ui header">
          {{ $user->email }}
          <div class="sub header">
            Email
          </div>
        </h3>
      </div>
    </div>

    @if ($user->sales->count() > 0)
    <div class="ui dividing header">Sales</div>
    <div class="ui divided items">
      @foreach ($user->sales->sortByDesc('created_at') as $sale)
      <div class="item">
        <div class="content">
          <a href="/admin/sales#/{{ $sale->id }}" class="header">Sale #{{ $sale->id }}</a>
          @if ($sale->events->count() > 0)
          <div class="meta">Events</div>
          <div class="extra">
            @foreach ($sale->events as $event)
              <div class="ui black label">{{ $event->show->name }}</div>
            @endforeach
          </div>
          @endif
          @if ($sale->products->count() > 0)
          <div class="meta">Products</div>
          <div class="extra">
            @foreach ($sale->products->unique('id') as $product)
              <div class="ui black label">
                <i class="box icon"></i>
                {{ $product->name }}
              <div class="detail">{{ $sale->products->where('id', $product->id)->count() }}</div>
              </div>
            @endforeach
          </div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    @endif

  </div>

  @include('admin.partial.users._edit')

  <?php
    $csrf = csrf_field();
    $action = route('admin.users.destroy', $user)
  ?>

  @include('admin.partial._basic-modal', [
    'id'       => 'delete-user',
    'icon'     => 'trash',
    'title'    => "You are about to delete a user!",
    'subtitle' => "Are you sure you want to permanently delete the <strong>{$user->role->name}</strong> user <strong>{$user->firstname}</strong> ?",
    'actions'  => "
    <form method='POST' action='{$action}'>
      {$csrf}
      <input type='hidden' name='_method' value='delete' />
      <button type='submit' class='ui inverted red button'><i class='trash icon'></i>Yes, Delete {$user->fullname}</button>
    </form>"
  ])

@endsection
