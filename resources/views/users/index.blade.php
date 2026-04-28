@extends('layouts.app')

@section('page_title', 'User Management')

@section('content')
<div class="container-fluid">
  <!-- Page header -->
  <div class="row align-items-center justify-content-between mb-4">
    <div class="col-md-6">
      <h4 class="mb-1">User Management</h4>
      <small class="text-muted">Manage all users in the system</small>
    </div>
    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
      <div class="col-md-6 text-end">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
          <i class="bx bx-plus"></i> Add New User
        </a>
      </div>
    @endif
  </div>

  <!-- Cards -->
  <div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-2">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <small class="text-muted d-block">Total Users</small>
              <h5 class="mb-0">{{ $users->total() + request('page', 1) * 0 }}</h5>
            </div>
            <i class="bx bx-user text-primary" style="font-size: 2rem;"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-2">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <small class="text-muted d-block">Active Users</small>
              <h5 class="mb-0" id="activeCount">0</h5>
            </div>
            <i class="bx bx-check-circle text-success" style="font-size: 2rem;"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-2">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <small class="text-muted d-block">Admins</small>
              <h5 class="mb-0" id="adminCount">0</h5>
            </div>
            <i class="bx bx-crown text-warning" style="font-size: 2rem;"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-2">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <small class="text-muted d-block">Managers</small>
              <h5 class="mb-0" id="managerCount">0</h5>
            </div>
            <i class="bx bx-briefcase text-info" style="font-size: 2rem;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filters -->
  <div class="card shadow-sm mb-4 border-0">
    <div class="card-body">
      <form method="GET" action="{{ route('users.index') }}" class="row g-3">
        <div class="col-md-5">
          <label class="form-label">Search by Name, Email or Phone</label>
          <input 
            type="text" 
            name="search" 
            class="form-control" 
            placeholder="e.g. John, john@example.com, +1234567890" 
            value="{{ request('search') }}"
          />
        </div>
        <div class="col-md-3">
          <label class="form-label">Filter by Role</label>
          <select name="role" class="form-select">
            <option value="">All Roles</option>
            @foreach($roles as $role)
              <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                {{ ucfirst($role->name) }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="">All</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-2">
          <button type="submit" class="btn btn-primary w-100">
            <i class="bx bx-search"></i> Search
          </button>
          @if(request('search') || request('role') || request('status'))
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary" title="Reset filters">
              <i class="bx bx-reset"></i> Reset
            </a>
          @endif
        </div>
      </form>
    </div>
  </div>

  @if($errors->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ $errors->first('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Table -->
  <div class="card shadow-sm border-0">
    <div class="table-responsive">
      <table class="table mb-0">
        <thead class="table-light">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Roles</th>
            <th>Status</th>
            <th>Joined</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
            <tr>
              <td class="fw-medium">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar">
                    <img 
                      src="{{ asset('assets/img/avatars/1.png') }}" 
                      alt="{{ $user->name }}" 
                      class="rounded-circle" 
                      style="width: 32px; height: 32px;"
                    >
                  </div>
                  {{ $user->name }}
                </div>
              </td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->phone ?? '—' }}</td>
              <td>
                @foreach($user->roles as $role)
                  <span class="badge me-1 {{ $role->name === 'admin' ? 'bg-danger' : ($role->name === 'manager' ? 'bg-warning' : 'bg-info') }}">
                    {{ ucfirst($role->name) }}
                  </span>
                @endforeach
              </td>
              <td>
                @if($user->is_active)
                  <span class="badge bg-success">Active</span>
                @else
                  <span class="badge bg-secondary">Inactive</span>
                @endif
              </td>
              <td><small>{{ $user->created_at->format('M d, Y') }}</small></td>
              <td class="text-center">
                <div class="dropdown">
                  <button 
                    type="button" 
                    class="btn btn-sm btn-icon btn-text-secondary dropdown-toggle hide-arrow" 
                    data-bs-toggle="dropdown"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('users.show', $user) }}">
                      <i class="bx bx-show me-2"></i> View
                    </a>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                      <a class="dropdown-item" href="{{ route('users.edit', $user) }}">
                        <i class="bx bx-edit-alt me-2"></i> Edit
                      </a>
                      @if(auth()->id() !== $user->id && auth()->user()->hasRole('admin'))
                        <div class="dropdown-divider"></div>
                        <a 
                          class="dropdown-item text-danger" 
                          href="#" 
                          data-bs-toggle="modal" 
                          data-bs-target="#deleteModal"
                          data-user-id="{{ $user->id }}"
                          data-user-name="{{ $user->name }}"
                        >
                          <i class="bx bx-trash me-2"></i> Delete
                        </a>
                      @endif
                    @endif
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">
                <i class="bx bx-inbox" style="font-size: 3rem;"></i>
                <p class="mt-2">No users found</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  @if($users->hasPages())
    <div class="d-flex justify-content-center mt-4">
      {{ $users->links() }}
    </div>
  @endif
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this user? This action cannot be undone.</p>
        <p class="mb-0"><strong>User: <span id="deleteUserName"></span></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteForm" method="POST" style="display: inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete User</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('page-scripts')
<script>
// Delete Modal Functionality
document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const userId = button.getAttribute('data-user-id');
    const userName = button.getAttribute('data-user-name');
    
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deleteForm').action = "{{ route('users.destroy', ':id') }}".replace(':id', userId);
});

// Calculate stats from current table data
document.addEventListener('DOMContentLoaded', function() {
    let activeCounts = { active: 0, admin: 0, manager: 0 };
    
    document.querySelectorAll('tbody tr').forEach(row => {
        // Count active users
        const statusBadge = row.querySelector('td:nth-child(5) .badge');
        if (statusBadge && statusBadge.textContent.trim() === 'Active') {
            activeCounts.active++;
        }
        
        // Count by role
        const roleBadges = row.querySelectorAll('td:nth-child(4) .badge');
        roleBadges.forEach(badge => {
            const role = badge.textContent.trim().toLowerCase();
            if (role === 'admin') activeCounts.admin++;
            if (role === 'manager') activeCounts.manager++;
        });
    });
    
    document.getElementById('activeCount').textContent = activeCounts.active;
    document.getElementById('adminCount').textContent = activeCounts.admin;
    document.getElementById('managerCount').textContent = activeCounts.manager;
});
</script>
@endpush
