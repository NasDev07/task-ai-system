<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register - AI Sales Page Generator</title>
  
  <!-- Bootstrap 5.3 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    body {
      background: #0066cc;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .register-container {
      width: 100%;
      max-width: 450px;
      padding: 20px;
    }
    
    .register-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      padding: 40px;
    }
    
    .register-header {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .register-header h3 {
      color: #0066cc;
      font-weight: 700;
      margin-bottom: 5px;
    }
    
    .register-header p {
      color: #999;
      font-size: 14px;
      margin: 0;
    }
    
    .form-control {
      border-radius: 8px;
      border: 1px solid #e0e0e0;
      padding: 10px 12px;
    }
    
    .form-control:focus {
      border-color: #0066cc;
      box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
    }
    
    .btn-register {
      background: #0066cc;
      border: none;
      padding: 10px 20px;
      font-weight: 600;
      border-radius: 8px;
      width: 100%;
    }
    
    .btn-register:hover {
      background: #0052a3;
      color: white;
    }
    
    .login-link {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
    }
    
    .login-link a {
      color: #0066cc;
      text-decoration: none;
      font-weight: 600;
    }
    
    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="register-container">
    <div class="register-card">
      <div class="register-header">
        <h3>AI Sales Page Generator</h3>
        <p>Create Your Account</p>
      </div>

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
          <strong>Registration Failed!</strong>
          <ul class="mb-0 mt-2 ps-3">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <form method="POST" action="{{ route('register.store') }}" class="mb-3">
        @csrf

        <div class="mb-3">
          <label class="form-label" for="name">Full Name</label>
          <input 
            type="text" 
            class="form-control @error('name') is-invalid @enderror" 
            id="name" 
            name="name" 
            placeholder="John Doe"
            value="{{ old('name') }}"
            required
          >
          @error('name')
            <small class="invalid-feedback">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="email">Email Address</label>
          <input 
            type="email" 
            class="form-control @error('email') is-invalid @enderror" 
            id="email" 
            name="email" 
            placeholder="john@example.com"
            value="{{ old('email') }}"
            required
          >
          @error('email')
            <small class="invalid-feedback">{{ $message }}</small>
          @enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="password">Password</label>
            <input 
              type="password" 
              class="form-control @error('password') is-invalid @enderror" 
              id="password" 
              name="password" 
              placeholder="••••••••"
              required
            >
            <small class="text-muted">Min. 8 characters</small>
            @error('password')
              <small class="invalid-feedback d-block">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input 
              type="password" 
              class="form-control @error('password_confirmation') is-invalid @enderror" 
              id="password_confirmation" 
              name="password_confirmation" 
              placeholder="••••••••"
              required
            >
            @error('password_confirmation')
              <small class="invalid-feedback d-block">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
          <label class="form-check-label small" for="agree">
            I agree to the terms and conditions
          </label>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-2">
          Create Account
        </button>
      </form>

      <div class="divider text-center my-3" style="position: relative;">
        <span style="background: white; padding: 0 10px; color: #ccc; font-size: 12px;">OR</span>
      </div>

      <p class="text-center small text-muted mb-0">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a>
      </p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
