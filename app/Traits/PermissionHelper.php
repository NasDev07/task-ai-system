<?php

namespace App\Traits;

use Illuminate\Support\Facades\Gate;

/**
 * PermissionHelper Trait
 * 
 * Provides convenient methods for permission checking and authorization
 * throughout the application.
 * 
 * Usage in Controllers:
 * 
 *   class UserController extends Controller
 *   {
 *       use PermissionHelper;
 *       
 *       public function index()
 *       {
 *           $this->checkPermission('view users');
 *           // OR use the enum
 *           $this->checkPermission(\App\Enums\Permission::VIEW_USERS);
 *       }
 *   }
 * 
 * Usage in Blade:
 * 
 *   @if(auth()->user()->hasAnyPermission('view users', 'edit users'))
 *       <!-- Show content -->
 *   @endif
 */
trait PermissionHelper
{
  /**
   * Convert Permission enum to string if needed
   */
  private function toPermissionString($permission): string
  {
    return $permission instanceof \App\Enums\Permission
      ? $permission->value
      : (string)$permission;
  }

  /**
   * Check if user has permission, abort if not
   * 
   * @param string|\App\Enums\Permission $permission Permission name or Enum value
   * @param int $statusCode HTTP status code (default 403)
   * @return void
   */
  protected function checkPermission($permission, int $statusCode = 403): void
  {
    $permissionString = $this->toPermissionString($permission);

    if (auth()->user()->cannot($permissionString)) {
      abort($statusCode, 'Unauthorized: You do not have permission to access this resource.');
    }
  }

  /**
   * Check if user has any of the given permissions
   * 
   * @param array|string|\App\Enums\Permission $permissions Permission names or Enum values
   * @return bool
   */
  protected function hasAnyPermission($permissions): bool
  {
    $permissions = is_array($permissions) ? $permissions : [$permissions];

    foreach ($permissions as $permission) {
      $permissionString = $this->toPermissionString($permission);
      if (auth()->user()->can($permissionString)) {
        return true;
      }
    }

    return false;
  }

  /**
   * Check if user has all of the given permissions
   * 
   * @param array|string|\App\Enums\Permission $permissions Permission names or Enum values
   * @return bool
   */
  protected function hasAllPermissions($permissions): bool
  {
    $permissions = is_array($permissions) ? $permissions : [$permissions];

    foreach ($permissions as $permission) {
      $permissionString = $this->toPermissionString($permission);
      if (auth()->user()->cannot($permissionString)) {
        return false;
      }
    }

    return true;
  }

  /**
   * Get permissions as array
   * 
   * @return array
   */
  protected function getPermissions(): array
  {
    return auth()->user()->getAllPermissions()->pluck('name')->toArray();
  }

  /**
   * Get permissions grouped by category
   * 
   * @return array
   */
  protected function getPermissionsGrouped(): array
  {
    $userPermissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
    $grouped = \App\Enums\Permission::grouped();

    $result = [];
    foreach ($grouped as $category => $permissions) {
      $result[$category] = [];
      foreach ($permissions as $permission) {
        $value = is_object($permission) ? $permission->value : $permission;
        if (in_array($value, $userPermissions)) {
          $result[$category][] = $value;
        }
      }
    }

    return array_filter($result, fn($perms) => count($perms) > 0);
  }

  /**
   * Check if user is admin
   * 
   * @return bool
   */
  protected function isAdmin(): bool
  {
    return auth()->user()->hasRole('admin');
  }

  /**
   * Check if user is manager
   * 
   * @return bool
   */
  protected function isManager(): bool
  {
    return auth()->user()->hasRole('manager');
  }

  /**
   * Check if user is regular user
   * 
   * @return bool
   */
  protected function isRegularUser(): bool
  {
    return auth()->user()->hasRole('user');
  }
}
