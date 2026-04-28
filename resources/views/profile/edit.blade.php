@extends('layouts.app')

@section('page_title', 'Edit Profile')

@section('content')
<div class="container-fluid">
  <div class="row mb-4">
    <div class="col-12">
      <h4 class="mb-1">Edit Profile</h4>
      <small class="text-muted">Update your personal information</small>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
              <strong>Validation Errors:</strong>
              <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <form method="POST" action="#" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label" for="name">Full Name</label>
              <input 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                id="name" 
                name="name" 
                value="{{ auth()->user()->name }}"
                disabled
              >
              <small class="text-muted">Managed by administrators</small>
            </div>

            <div class="mb-3">
              <label class="form-label" for="email">Email Address</label>
              <input 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                id="email" 
                name="email" 
                value="{{ auth()->user()->email }}"
                disabled
              >
              <small class="text-muted">Managed by administrators</small>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label" for="phone">Phone</label>
                <input 
                  type="tel" 
                  class="form-control @error('phone') is-invalid @enderror" 
                  id="phone" 
                  name="phone" 
                  placeholder="+1 (555) 000-0000"
                  value="{{ auth()->user()->phone }}"
                >
                @error('phone')
                  <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label" for="address">Address</label>
                <input 
                  type="text" 
                  class="form-control @error('address') is-invalid @enderror" 
                  id="address" 
                  name="address" 
                  placeholder="123 Main Street"
                  value="{{ auth()->user()->address }}"
                >
                @error('address')
                  <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label" for="city">City</label>
                <input 
                  type="text" 
                  class="form-control @error('city') is-invalid @enderror" 
                  id="city" 
                  name="city" 
                  placeholder="New York"
                  value="{{ auth()->user()->city }}"
                >
                @error('city')
                  <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label" for="country">Country</label>
                <input 
                  type="text" 
                  class="form-control @error('country') is-invalid @enderror" 
                  id="country" 
                  name="country" 
                  placeholder="United States"
                  value="{{ auth()->user()->country }}"
                >
                @error('country')
                  <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="postal_code">Postal Code</label>
              <input 
                type="text" 
                class="form-control @error('postal_code') is-invalid @enderror" 
                id="postal_code" 
                name="postal_code" 
                placeholder="10001"
                value="{{ auth()->user()->postal_code }}"
              >
              @error('postal_code')
                <small class="invalid-feedback">{{ $message }}</small>
              @enderror
            </div>

            <div class="alert alert-info small">
              <i class="bx bx-info-circle"></i> 
              To change your name or email, please contact an administrator.
            </div>

            <div class="pt-3 border-top d-flex gap-2">
              <button type="submit" class="btn btn-primary" disabled>
                <i class="bx bx-check me-1"></i> Save Changes
              </button>
              <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Cancel
              </a>
            </div>
          </form>
        </div>
      </div>

      <!-- Change Password Section -->
      <div class="card shadow-sm border-0 mt-3">
        <div class="card-header bg-light">
          <h6 class="mb-0">Change Password</h6>
        </div>
        <div class="card-body">
          <form method="POST" action="#" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label" for="current_password">Current Password</label>
              <input 
                type="password" 
                class="form-control" 
                id="current_password" 
                name="current_password" 
                placeholder="••••••••"
              >
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label" for="new_password">New Password</label>
                <input 
                  type="password" 
                  class="form-control" 
                  id="new_password" 
                  name="new_password" 
                  placeholder="••••••••"
                >
                <small class="text-muted">Minimum 8 characters</small>
              </div>

              <div class="col-md-6">
                <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
                <input 
                  type="password" 
                  class="form-control" 
                  id="new_password_confirmation" 
                  name="new_password_confirmation" 
                  placeholder="••••••••"
                >
              </div>
            </div>

            <div class="pt-3 border-top">
              <button type="submit" class="btn btn-primary" disabled>
                <i class="bx bx-check me-1"></i> Update Password
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
