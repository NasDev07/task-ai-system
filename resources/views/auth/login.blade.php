<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - AI Sales Page Generator</title>
  
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
    
    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 20px;
    }
    
    .login-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      padding: 40px;
    }
    
    .login-header {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .login-header h3 {
      color: #0066cc;
      font-weight: 700;
      margin-bottom: 5px;
    }
    
    .login-header p {
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
    
    .btn-login {
      background: #0066cc;
      border: none;
      padding: 10px 20px;
      font-weight: 600;
      border-radius: 8px;
      width: 100%;
    }
    
    .btn-login:hover {
      background: #0052a3;
      color: white;
    }
    
    .register-link {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
    }
    
    .register-link a {
      color: #0066cc;
      text-decoration: none;
      font-weight: 600;
    }
    
    .register-link a:hover {
      text-decoration: underline;
    }
    
    .error-alert {
      border-radius: 8px;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h3>AI Sales Page Generator</h3>
        <p>Sign In to Your Account</p>
      </div>

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show error-alert" role="alert">
          <strong>Login Failed!</strong>
          @foreach($errors->all() as $error)
            <div style="font-size: 14px;">{{ $error }}</div>
          @endforeach
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label" for="email">Email Address</label>
          <input 
            type="email" 
            class="form-control @error('email') is-invalid @enderror" 
            id="email" 
            name="email" 
            placeholder="you@example.com"
            value="{{ old('email') }}"
            required
            autofocus
          >
          @error('email')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="password">Password</label>
          <input 
            type="password" 
            class="form-control @error('password') is-invalid @enderror" 
            id="password" 
            name="password" 
            placeholder="Enter your password"
            required
          >
          @error('password')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3 form-check">
          <input 
            class="form-check-input" 
            type="checkbox" 
            id="remember" 
            name="remember"
          >
          <label class="form-check-label" for="remember">
            Remember me
          </label>
        </div>

        <button type="submit" class="btn btn-primary btn-login">Sign In</button>
      </form>

      <div class="register-link">
        Don't have an account? 
        <a href="{{ route('register') }}">Sign up here</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
