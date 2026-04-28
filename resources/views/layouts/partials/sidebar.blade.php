<!-- Sidebar -->
<aside class="sidebar" style="width: 250px; min-height: 100vh;">
  <div class="p-3 mb-4">
    <a href="{{ route('dashboard') }}" class="text-decoration-none text-white">
      <h5 class="mb-0"><i class="fas fa-rocket me-2"></i>AI Sales Page</h5>
    </a>
  </div>

  <nav class="nav flex-column">
    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
      <i class="fas fa-home me-2"></i> Dashboard
    </a>

    <!-- User Management (Admin & Manager Only) -->
    @if(auth()->user() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')))
      <div class="mt-3 pt-2" style="border-top: 1px solid rgba(255,255,255,0.3);">
        <small class="text-uppercase text-white" style="opacity: 0.7;">Management</small>
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
          <i class="fas fa-users me-2"></i> Users
        </a>
      </div>
    @endif

    <!-- Sales Pages Tool -->
    <div class="mt-3 pt-2" style="border-top: 1px solid rgba(255,255,255,0.3);">
      <small class="text-uppercase text-white" style="opacity: 0.7;">Tools</small>
      <a href="{{ route('sales-page.index') }}" class="nav-link {{ request()->routeIs('sales-page.index') ? 'active' : '' }}">
        <i class="fas fa-file-alt me-2"></i> Create Sales Page
      </a>
      <a href="{{ route('sales-page.history') }}" class="nav-link {{ request()->routeIs('sales-page.history') ? 'active' : '' }}">
        <i class="fas fa-history me-2"></i> My Pages
      </a>
    </div>

    <!-- Account Section -->
    <div class="mt-3 pt-2" style="border-top: 1px solid rgba(255,255,255,0.3);">
      <small class="text-uppercase text-white" style="opacity: 0.7;">Account</small>
      <a href="{{ route('profile.edit') }}" class="nav-link">
        <i class="fas fa-cog me-2"></i> Settings
      </a>
      <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
          <i class="fas fa-sign-out-alt me-2"></i> Logout
        </button>
      </form>
    </div>
  </nav>
</aside>
    </li>
  </ul>
</aside>
<!-- / Menu -->
