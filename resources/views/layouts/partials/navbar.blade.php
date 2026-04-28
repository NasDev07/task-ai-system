<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top" style="box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
  <div class="container-fluid px-4">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="ms-auto">
        <div class="d-flex align-items-center gap-3">
          <!-- Search -->
          <div class="input-group" style="width: 200px;">
            <span class="input-group-text bg-white border-0">
              <i class="fas fa-search"></i>
            </span>
            <input type="text" class="form-control border-0" placeholder="Search...">
          </div>

          <!-- User Dropdown -->
          <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
              <i class="fas fa-user-circle me-2"></i>{{ auth()->user()->name ?? 'User' }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <span class="dropdown-item-text">
                  <strong>{{ auth()->user()->name ?? 'User' }}</strong><br>
                  <small class="text-muted">
                    @foreach(auth()->user()->roles as $role)
                      {{ ucfirst($role->name) }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                  </small>
                </span>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                  <i class="fas fa-user me-2"></i>My Profile
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cog me-2"></i>Settings
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt me-2"></i>Log Out
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
<!-- / Navbar -->
