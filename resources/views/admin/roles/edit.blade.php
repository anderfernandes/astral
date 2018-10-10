@extends('layout.admin')

@section('title', 'Edit Role')

@section('subtitle', $role->name)

@section('icon', 'users')

@section('content')

<div class="ui container">

  <form action="{{ route('admin.roles.update', $role) }}" class="ui form" method="POST">

  {{ method_field('PUT') }}

  {{ csrf_field() }}

  <div class="field">
    <a href="{{ route('admin.settings.index') }}#user-roles" class="ui basic black button"><i class="left chevron icon"></i> Back</a>
    <div class="ui positive right labeled submit icon button">Save <i class="save icon"></i></div>
  </div>

  <div class="three fields">

    <div class="field">
      <label for="name">Role Name</label>
      <input type="text" placeholder="Enter role name" name="name" value="{{ old('name') == null ? $role->name : old('name') }}">
    </div>

    <div class="field">
      <label for="staff">Staff?</label>
      <select name="staff" id="" class="ui dropdown">
        <option {{ $role->staff ? 'selected' : '' }} value="true">Yes</option>
        <option {{ $role->staff ? '' : 'selected' }} value="false">No</option>
      </select>
    </div>

    <div class="field">
      <label for="description">Role Description</label>
      <input type="text" name="description" placeholder="Describe the role" value="{{ old('description') == null ? $role->description : old('description') }}">
    </div>

  </div>

  <div class="ui dividing header">Default Role Permissions</div>
  <div class="ui icon message">
    <i class="info circle icon"></i>
    <div class="content">
      <div class="header">About Default Role Permissions</div>
      <p>
        These are standard permissions for when users accounts of this role are created. Changes here will only be applied
        to newly created accounts of this type.
      </p>
    </div>
  </div>
  <div class="ui icon message">
    <i class="info circle icon"></i>
    <div class="content">
      <div class="header">About Default Role Permissions</div>
      <p>
        Permissions set on individual accounts override the permissions set here.
      </p>
    </div>
  </div>

  <div class="two fields">

    <div class="field">

      <label for="admin">Grant access to admin</label>
      <select name="admin" class="ui dropdown">
        <option value="true">Yes</option>
        <option value="false">No</option>
      </select>

    </div>

    <div class="field">

      <label for="admin">Grant access to cashier</label>
      <select name="cashier" class="ui dropdown">
        <option value="true">Yes</option>
        <option value="false">No</option>
      </select>

    </div>

  </div>

  {{-- Dashboard --}}
  <div class="field">
    <label for="dashboard">Dashboard</label>
    <select name="dashboard[]" multiple="" class="ui fluid dropdown">
      <option {{ str_contains($role->permissions['dashboard'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['dashboard'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['dashboard'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['dashboard'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

  {{-- Shows --}}
  <div class="field">
    <label for="shows">Shows</label>
    <select name="shows[]" multiple="" class="ui fluid dropdown">
      <option {{ str_contains($role->permissions['shows'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['shows'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['shows'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['shows'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

  {{-- Products --}}
  <div class="field">
    <label for="products">Products</label>
    <select name="products[]" multiple="" class="ui fluid dropdown">
      <option {{ str_contains($role->permissions['products'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['products'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['products'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['products'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

  {{-- Calendar --}}
  <div class="field">
    <label for="calendar">Calendar</label>
    <select name="calendar[]" multiple="" class="ui fluid dropdown">
      <option {{ str_contains($role->permissions['calendar'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['calendar'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['calendar'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['calendar'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

  {{-- Sales --}}
  <div class="field">
    <label for="sales">Sales</label>
    <select name="sales[]" multiple="" class="ui fluid dropdown" >
      <option {{ str_contains($role->permissions['sales'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['sales'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['sales'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['sales'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

  {{-- Reports --}}
  <div class="field">
    <label for="reports">Reports</label>
    <select name="reports[]" multiple="" class="ui fluid dropdown">
      <option {{ str_contains($role->permissions['reports'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['reports'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['reports'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['reports'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

  {{-- Members --}}
  <div class="field">
    <label for="members">Members</label>
    <select name="members[]" multiple="" class="ui fluid dropdown">
      <option {{ str_contains($role->permissions['members'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['members'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['members'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['members'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

  {{-- Users --}}
  <div class="field">
    <label for="users">Users</label>
    <select name="users[]" multiple="" class="ui fluid dropdown">
      <option {{ str_contains($role->permissions['users'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['users'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['users'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['users'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

  {{-- Organizations --}}
  <div class="field">
    <label for="organizations">Organizations</label>
    <select name="organizations[]" multiple="" class="ui fluid dropdown">
      <option {{ str_contains($role->permissions['organizations'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['organizations'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['organizations'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['organizations'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

  {{-- Bulletin --}}
  <div class="field">
    <label for="bulletin">Bulletin</label>
    <select name="bulletin[]" multiple="" class="ui fluid dropdown">
      <option {{ str_contains($role->permissions['bulletin'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['bulletin'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['bulletin'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['bulletin'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

  {{-- Settings --}}
  <div class="field">
    <label for="settings">Settings</label>
    <select name="settings[]" multiple="" class="ui fluid dropdown">
      <option {{ str_contains($role->permissions['settings'], "C") ? 'selected' : '' }} value="C">Create</option>
      <option {{ str_contains($role->permissions['settings'], "R") ? 'selected' : '' }} value="R">Read</option>
      <option {{ str_contains($role->permissions['settings'], "U") ? 'selected' : '' }} value="U">Update</option>
      <option {{ str_contains($role->permissions['settings'], "D") ? 'selected' : '' }} value="D">Delete</option>
      <option value="">No Access</option>
    </select>
  </div>

</form>

</div>

<script>

  $('form').form({
    inline : true,
    on     : 'blur',
    fields : {
      name        : ['empty', 'minLength[3]'],
      staff       : 'empty',
      description : 'empty',
    }
  })

</script>
@endsection
