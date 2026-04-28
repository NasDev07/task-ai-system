@extends('layouts.app')

@section('page_title', 'Edit User')

@section('content')
<div class="container-fluid">
  <div class="row mb-4">
    <div class="col-12">
      <h4 class="mb-1">Edit User</h4>
      <small class="text-muted">Update user information and roles</small>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8 mx-auto">
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

          <form method="POST" action="{{ route('users.update', $user) }}" novalidate>
            @csrf
            @method('PUT')

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  class="form-control @error('name') is-invalid @enderror" 
                  id="name" 
                  name="name" 
                  placeholder="John Doe"
                  value="{{ old('name', $user->name) }}"
                  required
                >
                @error('name')
                  <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                <input 
                  type="email" 
                  class="form-control @error('email') is-invalid @enderror" 
                  id="email" 
                  name="email" 
                  placeholder="john@example.com"
                  value="{{ old('email', $user->email) }}"
                  required
                >
                @error('email')
                  <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label" for="password">Password</label>
                <input 
                  type="password" 
                  class="form-control @error('password') is-invalid @enderror" 
                  id="password" 
                  name="password" 
                  placeholder="••••••••"
                >
                <small class="text-muted">Leave blank to keep current password. Minimum 8 characters if changed.</small>
                @error('password')
                  <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input 
                  type="password" 
                  class="form-control @error('password_confirmation') is-invalid @enderror" 
                  id="password_confirmation" 
                  name="password_confirmation" 
                  placeholder="••••••••"
                >
                @error('password_confirmation')
                  <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
              </div>
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
                  value="{{ old('phone', $user->phone) }}"
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
                  value="{{ old('address', $user->address) }}"
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
                  value="{{ old('city', $user->city) }}"
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
                  value="{{ old('country', $user->country) }}"
                >
                @error('country')
                  <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label" for="postal_code">Postal Code</label>
                <input 
                  type="text" 
                  class="form-control @error('postal_code') is-invalid @enderror" 
                  id="postal_code" 
                  name="postal_code" 
                  placeholder="10001"
                  value="{{ old('postal_code', $user->postal_code) }}"
                >
                @error('postal_code')
                  <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label" for="is_active">Status</label>
                <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                  <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active')
                  <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Roles <span class="text-danger">*</span></label>
              <div class="position-relative">
                @foreach($roles as $role)
                  <div class="form-check">
                    <input 
                      class="form-check-input @error('roles') is-invalid @enderror" 
                      type="checkbox" 
                      name="roles[]" 
                      value="{{ $role->id }}" 
                      id="role_{{ $role->id }}"
                      {{ $user->roles->contains('id', $role->id) || in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="role_{{ $role->id }}">
                      {{ ucfirst($role->name) }}
                    </label>
                  </div>
                @endforeach
                @error('roles')
                  <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="alert alert-info small mb-3">
              <i class="bx bx-info-circle"></i> 
              <strong>User Created:</strong> {{ $user->created_at->format('M d, Y @ H:i') }}
              @if($user->updated_at->format('Y-m-d') !== $user->created_at->format('Y-m-d'))
                | <strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y @ H:i') }}
              @endif
            </div>

            <div class="pt-3 border-top d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="bx bx-check me-1"></i> Update User
              </button>
              <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Cancel
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
