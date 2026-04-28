@extends('layouts.app')

@section('page_title', 'User Dashboard')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <h4 class="mb-1">Welcome, {{ auth()->user()->name }}! 👋</h4>
      <p class="text-muted mb-0">Here's what's happening with your account today.</p>
    </div>
  </div>

  <!-- Profile Overview Card -->
  <div class="row mb-4 g-3">
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
          <div class="avatar-lg rounded-circle bg-primary bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
            <i class="bx bx-user text-primary" style="font-size: 40px;"></i>
          </div>
          <h5 class="mb-2">{{ auth()->user()->name }}</h5>
          <div class="mb-3">
            @foreach(auth()->user()->roles as $role)
              <span class="badge bg-info text-dark me-1">{{ ucfirst($role->name) }}</span>
            @endforeach
          </div>
          <p class="text-muted small mb-3">
            <i class="bx bx-envelope me-1"></i> {{ auth()->user()->email }}
          </p>
          <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm w-100">
            <i class="bx bx-edit me-1"></i> Edit Profile
          </a>
        </div>
      </div>
    </div>

    <!-- Account Stats -->
    <div class="col-lg-8">
      <div class="row g-3">
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <p class="text-muted small mb-1">Account Status</p>
                  @if(auth()->user()->is_active)
                    <span class="badge bg-success fs-6">Active</span>
                  @else
                    <span class="badge bg-secondary fs-6">Inactive</span>
                  @endif
                </div>
                <i class="bx bx-check-circle text-success" style="font-size: 24px;"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <p class="text-muted small mb-1">Email Verification</p>
                  @if(auth()->user()->email_verified_at)
                    <span class="badge bg-success fs-6">Verified</span>
                  @else
                    <span class="badge bg-warning text-dark fs-6">Pending</span>
                  @endif
                </div>
                <i class="bx bx-shield-check text-info" style="font-size: 24px;"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <p class="text-muted small mb-1">Member Since</p>
                  <p class="mb-0">{{ auth()->user()->created_at->format('M Y') }}</p>
                </div>
                <i class="bx bx-calendar text-warning" style="font-size: 24px;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Details Section -->
  <div class="row g-3">
    <!-- Personal Information -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-bottom py-3">
          <h6 class="mb-0 fw-bold">Personal Information</h6>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <small class="text-muted d-block mb-1">Full Name</small>
            <p class="mb-0 fw-medium">{{ auth()->user()->name }}</p>
          </div>
          <div class="mb-3">
            <small class="text-muted d-block mb-1">Email Address</small>
            <p class="mb-0 fw-medium">{{ auth()->user()->email }}</p>
          </div>
          @if(auth()->user()->phone)
            <div class="mb-3">
              <small class="text-muted d-block mb-1">Phone</small>
              <p class="mb-0 fw-medium">{{ auth()->user()->phone }}</p>
            </div>
          @endif
          @if(auth()->user()->address || auth()->user()->city)
            <div>
              <small class="text-muted d-block mb-1">Address</small>
              <p class="mb-0 fw-medium">
                @if(auth()->user()->address)
                  {{ auth()->user()->address }}
                @endif
                @if(auth()->user()->city)
                  {{ auth()->user()->city }}
                @endif
                @if(auth()->user()->country)
                  {{ auth()->user()->country }}
                @endif
              </p>
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Account Details -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-bottom py-3">
          <h6 class="mb-0 fw-bold">Account Details</h6>
        </div>
        <div class="card-body">
          <div class="mb-3 pb-3 border-bottom">
            <small class="text-muted d-block mb-1">Account Created</small>
            <p class="mb-0 fw-medium">{{ auth()->user()->created_at->format('F d, Y') }}</p>
            <small class="text-muted">{{ auth()->user()->created_at->diffForHumans() }}</small>
          </div>
          <div class="mb-3 pb-3 border-bottom">
            <small class="text-muted d-block mb-1">Last Updated</small>
            <p class="mb-0 fw-medium">{{ auth()->user()->updated_at->format('F d, Y') }}</p>
            <small class="text-muted">{{ auth()->user()->updated_at->diffForHumans() }}</small>
          </div>
          <div>
            <small class="text-muted d-block mb-1">User ID</small>
            <code>{{ auth()->user()->id }}</code>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Security & Actions -->
  <div class="row mt-4 g-3">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-bottom py-3">
          <h6 class="mb-0 fw-bold">Quick Actions</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <a href="{{ route('profile.edit') }}" class="btn btn-primary w-100 mb-2">
                <i class="bx bx-edit me-2"></i> Edit Profile
              </a>
            </div>
            <div class="col-md-6">
              <button class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                <i class="bx bx-lock me-2"></i> Change Password
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-0">
      <div class="modal-header bg-light border-bottom">
        <h5 class="modal-title">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted small mb-3">Enter your current password and new password to change your credentials.</p>
        <form>
          <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" class="form-control" placeholder="••••••••">
          </div>
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" class="form-control" placeholder="••••••••">
            <small class="text-muted">Minimum 8 characters</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" placeholder="••••••••">
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light border-top">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Update Password</button>
      </div>
    </div>
  </div>
</div>
@endsection
