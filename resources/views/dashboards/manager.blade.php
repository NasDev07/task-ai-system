@extends('layouts.app')

@section('page_title', 'Manager Dashboard')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Dashboard</h4>
          <p class="text-muted mb-0">Team management overview</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistics Cards Row -->
  <div class="row mb-4 g-3">
    <div class="col-lg-4 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Users</p>
              <h4 class="mb-0">{{ \App\Models\User::count() }}</h4>
              <small class="text-muted d-block mt-2">Active in system</small>
            </div>
            <div class="avatar rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-user text-primary" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Active Users</p>
              <h4 class="mb-0">{{ \App\Models\User::where('is_active', 1)->count() }}</h4>
              <small class="text-success">
                <i class="bx bx-arrow-up"></i> On duty
              </small>
            </div>
            <div class="avatar rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-check-circle text-success" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Verified Users</p>
              <h4 class="mb-0">{{ \App\Models\User::whereNotNull('email_verified_at')->count() }}</h4>
              <small class="text-muted">Email verified</small>
            </div>
            <div class="avatar rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bx bx-user-check text-info" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="row mb-4 g-3">
    <!-- Team Users Table -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
          <h6 class="mb-0 fw-bold">Team Members</h6>
          <div>
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
              <i class="bx bx-plus me-1"></i> Add User
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse(\App\Models\User::with('roles')->latest()->limit(10)->get() as $user)
                <tr>
                  <td>
                    <strong>{{ $user->name }}</strong>
                  </td>
                  <td>
                    <small class="text-muted">{{ $user->email }}</small>
                  </td>
                  <td>
                    @foreach($user->roles as $role)
                      <span class="badge bg-info text-dark">{{ ucfirst($role->name) }}</span>
                    @endforeach
                  </td>
                  <td>
                    @if($user->is_active)
                      <span class="badge bg-success">Active</span>
                    @else
                      <span class="badge bg-secondary">Inactive</span>
                    @endif
                  </td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('users.show', $user) }}">View</a></li>
                        <li><a class="dropdown-item" href="{{ route('users.edit', $user) }}">Edit</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">No users found</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Role Distribution -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h6 class="mb-0 fw-bold">Role Distribution</h6>
        </div>
        <div class="card-body">
          @foreach(\Spatie\Permission\Models\Role::all() as $role)
            <div class="mb-3 pb-3 border-bottom">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <p class="mb-0">{{ ucfirst($role->name) }}</p>
                <span class="badge bg-light text-dark">{{ $role->users->count() }}</span>
              </div>
              <div class="progress" style="height: 6px;">
                <div class="progress-bar" role="progressbar" style="width: {{ ($role->users->count() / max(\App\Models\User::count(), 1)) * 100 }}%;"></div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Stats -->
  <div class="row g-3">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h6 class="mb-0 fw-bold">Quick Statistics</h6>
        </div>
        <div class="card-body">
          <div class="row text-center">
            <div class="col-md-3">
              <div class="py-3">
                <h4 class="mb-1 text-primary">{{ \App\Models\User::count() }}</h4>
                <p class="text-muted small mb-0">Total Users</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="py-3">
                <h4 class="mb-1 text-success">{{ \App\Models\User::where('is_active', 1)->count() }}</h4>
                <p class="text-muted small mb-0">Active Today</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="py-3">
                <h4 class="mb-1 text-info">{{ \Spatie\Permission\Models\Role::findByName('manager')->users->count() ?? 0 }}</h4>
                <p class="text-muted small mb-0">Managers</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="py-3">
                <h4 class="mb-1 text-warning">{{ \App\Models\User::whereNull('email_verified_at')->count() }}</h4>
                <p class="text-muted small mb-0">Unverified</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
