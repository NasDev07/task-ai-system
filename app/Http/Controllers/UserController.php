<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Models\User;
use App\Traits\PermissionHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  use PermissionHelper;

  public function index(Request $request)
  {
    $this->checkPermission(Permission::VIEW_USERS);

    $query = User::with('roles')->orderBy('created_at', 'desc');

    if ($request->filled('role')) {
      $query->whereHas('roles', fn(Builder $q) => $q->where('name', $request->role));
    }

    if ($request->filled('status')) {
      $query->where('is_active', $request->status === 'active');
    }

    if ($request->filled('search')) {
      $search = "%{$request->search}%";
      $query->where(function (Builder $q) use ($search) {
        $q->where('name', 'like', $search)
          ->orWhere('email', 'like', $search)
          ->orWhere('phone', 'like', $search);
      });
    }

    $users = $query->paginate(15);
    $roles = Role::all();

    return view('users.index', compact('users', 'roles'));
  }

  public function create()
  {
    $this->checkPermission(Permission::CREATE_USERS);
    $roles = Role::all();
    return view('users.create', compact('roles'));
  }

  public function store(Request $request)
  {
    $this->checkPermission(Permission::CREATE_USERS);

    $validated = $request->validate([
      'name' => 'required|string|max:255|min:2',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:8|confirmed',
      'phone' => 'nullable|string|max:20|unique:users,phone',
      'address' => 'nullable|string|max:255',
      'city' => 'nullable|string|max:255',
      'country' => 'nullable|string|max:255',
      'postal_code' => 'nullable|string|max:10',
      'is_active' => 'boolean',
      'roles' => 'required|array|min:1',
      'roles.*' => 'exists:roles,id',
    ]);

    $user = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => bcrypt($validated['password']),
      'phone' => $validated['phone'] ?? null,
      'address' => $validated['address'] ?? null,
      'city' => $validated['city'] ?? null,
      'country' => $validated['country'] ?? null,
      'postal_code' => $validated['postal_code'] ?? null,
      'is_active' => $validated['is_active'] ?? true,
      'email_verified_at' => now(),
      'profile_completion_percentage' => 50,
    ]);

    // Assign roles using proper Role models
    $roles = Role::whereIn('id', $validated['roles'])->get();
    $user->syncRoles($roles);

    return redirect()->route('users.index')
      ->with('success', "User '{$user->name}' created successfully!");
  }

  /**
   * Display the specified user details
   */
  public function show(User $user)
  {
    $this->checkPermission(Permission::VIEW_USER_PROFILE);
    $user->load('roles');
    return view('users.show', compact('user'));
  }

  public function edit(User $user)
  {
    $this->checkPermission(Permission::EDIT_USERS);
    $user->load('roles');
    $roles = Role::all();
    return view('users.edit', compact('user', 'roles'));
  }

  public function update(Request $request, User $user)
  {
    $this->checkPermission(Permission::EDIT_USERS);

    $validated = $request->validate([
      'name' => 'required|string|max:255|min:2',
      'email' => "required|email|unique:users,email,{$user->id}",
      'password' => 'nullable|string|min:8|confirmed',
      'phone' => "nullable|string|max:20|unique:users,phone,{$user->id}",
      'address' => 'nullable|string|max:255',
      'city' => 'nullable|string|max:255',
      'country' => 'nullable|string|max:255',
      'postal_code' => 'nullable|string|max:10',
      'is_active' => 'boolean',
      'roles' => 'required|array|min:1',
      'roles.*' => 'exists:roles,id',
    ]);

    $updateData = [
      'name' => $validated['name'],
      'email' => $validated['email'],
      'phone' => $validated['phone'] ?? null,
      'address' => $validated['address'] ?? null,
      'city' => $validated['city'] ?? null,
      'country' => $validated['country'] ?? null,
      'postal_code' => $validated['postal_code'] ?? null,
      'is_active' => $validated['is_active'] ?? true,
    ];

    // Only update password if provided
    if ($request->filled('password')) {
      $updateData['password'] = bcrypt($validated['password']);
    }

    $user->update($updateData);

    $roles = Role::whereIn('id', $validated['roles'])->get();
    $user->syncRoles($roles);

    return redirect()->route('users.index')
      ->with('success', "User '{$user->name}' updated successfully!");
  }

  public function destroy(User $user)
  {
    $this->checkPermission(Permission::DELETE_USERS);

    if (auth()->id() === $user->id) {
      return back()->withErrors(['error' => 'You cannot delete your own account!']);
    }

    $userName = $user->name;
    $user->delete();

    return redirect()->route('users.index')
      ->with('success', "User '{$userName}' deleted successfully!");
  }

  public function bulkToggleStatus(Request $request)
  {
    $this->checkPermission(Permission::BULK_EDIT_USERS);

    $validated = $request->validate([
      'ids' => 'required|array|min:1',
      'ids.*' => 'exists:users,id',
      'status' => 'required|boolean',
    ]);

    $count = User::whereIn('id', $validated['ids'])
      ->where('id', '!=', auth()->id())
      ->update(['is_active' => $validated['status']]);

    return back()->with('success', "{$count} user(s) status updated successfully!");
  }

  /**
   * Bulk assign roles to multiple users
   */
  public function bulkAssignRoles(Request $request)
  {
    $this->checkPermission(Permission::MANAGE_USERS_ROLE);

    $validated = $request->validate([
      'ids' => 'required|array|min:1',
      'ids.*' => 'exists:users,id',
      'roles' => 'required|array|min:1',
      'roles.*' => 'exists:roles,id',
    ]);

    $roles = Role::whereIn('id', $validated['roles'])->get();
    $count = 0;

    foreach ($validated['ids'] as $userId) {
      if ($userId !== auth()->id()) {
        User::find($userId)->syncRoles($roles);
        $count++;
      }
    }

    return back()->with('success', "Roles assigned to {$count} user(s)!");
  }
}
