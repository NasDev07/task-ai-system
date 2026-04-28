@extends('layouts.app')

@section('page_title', 'View User')

@section('content')
<div class="container-fluid">
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">{{ $user->name }}</h4>
          <small class="text-muted">User Profile</small>
        </div>
        @if(auth()->user()->hasAnyRole(['admin', 'manager']))
          <div>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">
              <i class="bx bx-edit me-1"></i> Edit User
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
              <i class="bx bx-arrow-back me-1"></i> Back
            </a>
          </div>
        @else
          <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-arrow-back me-1"></i> Back
          </a>
        @endif
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <!-- Personal Information -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-light">
          <h6 class="mb-0">Personal Information</h6>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <small class="text-muted d-block mb-1">Full Name</small>
              <p class="mb-0"><strong>{{ $user->name }}</strong></p>
            </div>
            <div class="col-md-6">
              <small class="text-muted d-block mb-1">Email</small>
              <p class="mb-0">
                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
              </p>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <small class="text-muted d-block mb-1">Phone</small>
              <p class="mb-0">
                {!! $user->phone ? $user->phone : '<em class="text-muted">Not provided</em>' !!}
              </p>
            </div>
            <div class="col-md-6">
              <small class="text-muted d-block mb-1">Status</small>
              <p class="mb-0">
                @if($user->is_active)
                  <span class="badge bg-success">Active</span>
                @else
                  <span class="badge bg-secondary">Inactive</span>
                @endif
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Address Information -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-light">
          <h6 class="mb-0">Address Information</h6>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <small class="text-muted d-block mb-1">Street Address</small>
              <p class="mb-0">
                {!! $user->address ? $user->address : '<em class="text-muted">Not provided</em>' !!}
              </p>
            </div>
            <div class="col-md-6">
              <small class="text-muted d-block mb-1">City</small>
              <p class="mb-0">
                {!! $user->city ? $user->city : '<em class="text-muted">Not provided</em>' !!}
              </p>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <small class="text-muted d-block mb-1">Country</small>
              <p class="mb-0">
                {!! $user->country ? $user->country : '<em class="text-muted">Not provided</em>' !!}
              </p>
            </div>
            <div class="col-md-6">
              <small class="text-muted d-block mb-1">Postal Code</small>
              <p class="mb-0">
                {!! $user->postal_code ? $user->postal_code : '<em class="text-muted">Not provided</em>' !!}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Role Information -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-light">
          <h6 class="mb-0">Role & Permissions</h6>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <small class="text-muted d-block mb-2">Assigned Roles</small>
            @if($user->roles->count() > 0)
              <div class="d-flex flex-wrap gap-2">
                @foreach($user->roles as $role)
                  <span class="badge bg-info text-dark">{{ ucfirst($role->name) }}</span>
                @endforeach
              </div>
            @else
              <p class="text-muted mb-0"><em>No roles assigned</em></p>
            @endif
          </div>

          <hr class="my-3">

          <div>
            <small class="text-muted d-block mb-2">Associated Permissions</small>
            @if($user->getAllPermissions()->count() > 0)
              <div class="d-flex flex-wrap gap-2">
                @foreach($user->getAllPermissions() as $permission)
                  <span class="badge bg-light text-dark border border-secondary">{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</span>
                @endforeach
              </div>
            @else
              <p class="text-muted mb-0"><em>No permissions assigned</em></p>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
      <!-- Account Statistics -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-light">
          <h6 class="mb-0">Account Information</h6>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <small class="text-muted d-block mb-1">Account Created</small>
            <p class="mb-0">
              <strong>{{ $user->created_at->format('M d, Y') }}</strong>
              <br>
              <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
            </p>
          </div>

          <hr class="my-2">

          <div class="mb-3">
            <small class="text-muted d-block mb-1">Last Updated</small>
            <p class="mb-0">
              <strong>{{ $user->updated_at->format('M d, Y') }}</strong>
              <br>
              <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
            </p>
          </div>

          <hr class="my-2">

          <div>
            <small class="text-muted d-block mb-1">User ID</small>
            <p class="mb-0">
              <code>{{ $user->id }}</code>
            </p>
          </div>
        </div>
      </div>

      <!-- Email Verification Status -->
      <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
          <h6 class="mb-0">Verification Status</h6>
        </div>
        <div class="card-body">
          <small class="text-muted d-block mb-2">Email Verification</small>
          @if($user->email_verified_at)
            <p class="mb-0">
              <span class="badge bg-success">Verified</span>
              <br>
              <small class="text-muted mt-1 d-block">{{ $user->email_verified_at->format('M d, Y @ H:i') }}</small>
            </p>
          @else
            <p class="mb-0">
              <span class="badge bg-warning text-dark">Not Verified</span>
            </p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
