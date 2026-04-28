<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Welcome/home page - accessible to everyone
Route::get('/', function () {
    // Redirect authenticated users to their dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// Guest middleware group
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    })->name('login.store');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function (Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'email_verified_at' => now(),
        ]);

        // Assign default 'user' role
        $user->syncRoles(['user']);

        Auth::login($user);

        return redirect()->route('dashboard');
    })->name('register.store');
});

// Logout route
Route::middleware('auth')->post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Protected Routes - Authenticated Users Only
Route::middleware('auth')->group(function () {

    // Dashboard routes - role-specific redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('dashboards.admin');
        } elseif ($user->hasRole('manager')) {
            return redirect()->route('dashboards.manager');
        } else {
            return redirect()->route('dashboards.user');
        }
    })->name('dashboard');

    // Admin Dashboard
    Route::get('/dashboards/admin', [DashboardController::class, 'admin'])
        ->middleware('role:admin')->name('dashboards.admin');

    // Manager Dashboard
    Route::get('/dashboards/manager', [DashboardController::class, 'manager'])
        ->middleware('role:admin,manager')->name('dashboards.manager');

    // User Dashboard
    Route::get('/dashboards/user', [DashboardController::class, 'user'])
        ->middleware('role:user,admin,manager')->name('dashboards.user');

    // User Management Routes - with role protection
    Route::middleware('role:admin,manager')->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');

        // Bulk operations
        Route::post('/bulk/toggle-status', [UserController::class, 'bulkToggleStatus'])
            ->name('bulk.toggle-status');
        Route::post('/bulk/assign-roles', [UserController::class, 'bulkAssignRoles'])
            ->name('bulk.assign-roles');
    });

    // Profile Routes
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    // Sales Page Routes
    Route::prefix('sales-page')->name('sales-page.')->group(function () {
        Route::get('/', [App\Http\Controllers\SalesPageController::class, 'index'])->name('index');
        Route::post('/generate', [App\Http\Controllers\SalesPageController::class, 'generate'])->name('generate');
        Route::get('/history', [App\Http\Controllers\SalesPageController::class, 'history'])->name('history');
        Route::get('/{salesPage}/edit', [App\Http\Controllers\SalesPageController::class, 'edit'])->name('edit');
        Route::put('/{salesPage}', [App\Http\Controllers\SalesPageController::class, 'update'])->name('update');
        Route::post('/{salesPage}/regenerate-section', [App\Http\Controllers\SalesPageController::class, 'regenerateSection'])->name('regenerate-section');
        Route::get('/{salesPage}/export', [App\Http\Controllers\SalesPageController::class, 'export'])->name('export');
        Route::get('/{salesPage}', [App\Http\Controllers\SalesPageController::class, 'show'])->name('show');
        Route::delete('/{salesPage}', [App\Http\Controllers\SalesPageController::class, 'destroy'])->name('destroy');
    });
});

// GitHub Webhook for auto-deployment
Route::post('/github-webhook', function (Illuminate\Http\Request $request) {
    // Get signature from GitHub header
    $signature = $request->header('X-Hub-Signature-256');
    $payload = file_get_contents('php://input');
    $secret = env('GITHUB_WEBHOOK_SECRET', '');

    if (!$secret) {
        \Log::error('GITHUB_WEBHOOK_SECRET not configured');
        return response('Secret not configured', 500);
    }

    // Verify signature
    $hash = 'sha256=' . hash_hmac('sha256', $payload, $secret);

    if (!hash_equals($hash, $signature ?? '')) {
        \Log::warning('Webhook signature verification failed', ['signature' => $signature]);
        return response('Unauthorized', 401);
    }

    // Parse payload
    $data = json_decode($payload, true);

    // Only process main branch
    if ($data['ref'] !== 'refs/heads/main') {
        \Log::info('Webhook skipped - not main branch', ['ref' => $data['ref']]);
        return response('Not main branch', 200);
    }

    try {
        // Execute deployment script
        $output = shell_exec('cd ' . base_path() . ' && bash scripts/deploy.sh 2>&1');

        \Log::info('GitHub webhook deployment executed', [
            'branch' => $data['ref'],
            'pusher' => $data['pusher']['name'] ?? 'unknown',
            'commits' => count($data['commits'] ?? []),
            'output' => $output
        ]);

        return response('Deployed successfully', 200);
    } catch (\Exception $e) {
        \Log::error('Deployment failed', ['error' => $e->getMessage()]);
        return response('Deployment error: ' . $e->getMessage(), 500);
    }
})->withoutMiddleware(['web', 'csrf']);