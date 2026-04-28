<?php

namespace App\Enums;

/**
 * Permission Enum - Central repository for all system permissions
 * 
 * This enum provides type-safe access to all permissions in the system.
 * Use these constants instead of hardcoding permission strings.
 */
enum Permission: string
{
  // ===== USER MANAGEMENT =====
  case VIEW_USERS = 'view users';
  case CREATE_USERS = 'create users';
  case EDIT_USERS = 'edit users';
  case DELETE_USERS = 'delete users';
  case EXPORT_USERS = 'export users';
  case MANAGE_USERS_ROLE = 'manage users role';
  case BULK_EDIT_USERS = 'bulk edit users';

    // ===== DASHBOARD & STATISTICS =====
  case VIEW_DASHBOARD = 'view dashboard';
  case VIEW_STATISTICS = 'view statistics';
  case VIEW_REPORTS = 'view reports';
  case EXPORT_REPORTS = 'export reports';
  case VIEW_ANALYTICS = 'view analytics';

    // ===== SYSTEM MANAGEMENT =====
  case VIEW_SYSTEM_LOGS = 'view system logs';
  case MANAGE_SYSTEM_LOGS = 'manage system logs';
  case VIEW_SYSTEM_SETTINGS = 'view system settings';
  case MANAGE_SYSTEM_SETTINGS = 'manage system settings';
  case MANAGE_CACHE = 'manage cache';
  case VIEW_SYSTEM_HEALTH = 'view system health';

    // ===== ROLE MANAGEMENT =====
  case VIEW_ROLES = 'view roles';
  case CREATE_ROLES = 'create roles';
  case EDIT_ROLES = 'edit roles';
  case DELETE_ROLES = 'delete roles';
  case MANAGE_ROLE_PERMISSIONS = 'manage role permissions';

    // ===== PERMISSION MANAGEMENT =====
  case VIEW_PERMISSIONS = 'view permissions';
  case MANAGE_PERMISSIONS = 'manage permissions';

    // ===== PROFILE MANAGEMENT =====
  case EDIT_OWN_PROFILE = 'edit own profile';
  case VIEW_OWN_PROFILE = 'view own profile';
  case EDIT_USER_PROFILE = 'edit user profile';
  case VIEW_USER_PROFILE = 'view user profile';
  case CHANGE_USER_PASSWORD = 'change user password';
  case VIEW_USER_ACTIVITY = 'view user activity';

    // ===== VERIFICATION & APPROVAL =====
  case VIEW_PENDING_USERS = 'view pending users';
  case VERIFY_USERS = 'verify users';
  case APPROVE_USERS = 'approve users';
  case REJECT_USERS = 'reject users';
  case MANAGE_VERIFICATION = 'manage verification';

    // ===== AUDIT & ACTIVITY =====
  case VIEW_ACTIVITY_LOGS = 'view activity logs';
  case MANAGE_ACTIVITY_LOGS = 'manage activity logs';
  case VIEW_AUDIT_TRAIL = 'view audit trail';
  case VIEW_USER_ACTIONS = 'view user actions';

    // ===== FILE MANAGEMENT =====
  case VIEW_FILES = 'view files';
  case UPLOAD_FILES = 'upload files';
  case DELETE_FILES = 'delete files';
  case MANAGE_FILE_STORAGE = 'manage file storage';

  /**
   * Get all permissions grouped by category
   */
  public static function grouped(): array
  {
    return [
      'User Management' => [
        self::VIEW_USERS,
        self::CREATE_USERS,
        self::EDIT_USERS,
        self::DELETE_USERS,
        self::EXPORT_USERS,
        self::MANAGE_USERS_ROLE,
        self::BULK_EDIT_USERS,
      ],
      'Dashboard & Statistics' => [
        self::VIEW_DASHBOARD,
        self::VIEW_STATISTICS,
        self::VIEW_REPORTS,
        self::EXPORT_REPORTS,
        self::VIEW_ANALYTICS,
      ],
      'System Management' => [
        self::VIEW_SYSTEM_LOGS,
        self::MANAGE_SYSTEM_LOGS,
        self::VIEW_SYSTEM_SETTINGS,
        self::MANAGE_SYSTEM_SETTINGS,
        self::MANAGE_CACHE,
        self::VIEW_SYSTEM_HEALTH,
      ],
      'Role Management' => [
        self::VIEW_ROLES,
        self::CREATE_ROLES,
        self::EDIT_ROLES,
        self::DELETE_ROLES,
        self::MANAGE_ROLE_PERMISSIONS,
      ],
      'Permission Management' => [
        self::VIEW_PERMISSIONS,
        self::MANAGE_PERMISSIONS,
      ],
      'Profile Management' => [
        self::EDIT_OWN_PROFILE,
        self::VIEW_OWN_PROFILE,
        self::EDIT_USER_PROFILE,
        self::VIEW_USER_PROFILE,
        self::CHANGE_USER_PASSWORD,
        self::VIEW_USER_ACTIVITY,
      ],
      'Verification & Approval' => [
        self::VIEW_PENDING_USERS,
        self::VERIFY_USERS,
        self::APPROVE_USERS,
        self::REJECT_USERS,
        self::MANAGE_VERIFICATION,
      ],
      'Audit & Activity' => [
        self::VIEW_ACTIVITY_LOGS,
        self::MANAGE_ACTIVITY_LOGS,
        self::VIEW_AUDIT_TRAIL,
        self::VIEW_USER_ACTIONS,
      ],
      'File Management' => [
        self::VIEW_FILES,
        self::UPLOAD_FILES,
        self::DELETE_FILES,
        self::MANAGE_FILE_STORAGE,
      ],
    ];
  }

  /**
   * Get all permission values
   */
  public static function all(): array
  {
    return array_map(fn($case) => $case->value, self::cases());
  }

  /**
   * Get permission label/description
   */
  public function label(): string
  {
    return match ($this) {
      self::VIEW_USERS => 'View Users',
      self::CREATE_USERS => 'Create Users',
      self::EDIT_USERS => 'Edit Users',
      self::DELETE_USERS => 'Delete Users',
      self::EXPORT_USERS => 'Export Users',
      self::MANAGE_USERS_ROLE => 'Manage User Roles',
      self::BULK_EDIT_USERS => 'Bulk Edit Users',

      self::VIEW_DASHBOARD => 'View Dashboard',
      self::VIEW_STATISTICS => 'View Statistics',
      self::VIEW_REPORTS => 'View Reports',
      self::EXPORT_REPORTS => 'Export Reports',
      self::VIEW_ANALYTICS => 'View Analytics',

      self::VIEW_SYSTEM_LOGS => 'View System Logs',
      self::MANAGE_SYSTEM_LOGS => 'Manage System Logs',
      self::VIEW_SYSTEM_SETTINGS => 'View System Settings',
      self::MANAGE_SYSTEM_SETTINGS => 'Manage System Settings',
      self::MANAGE_CACHE => 'Manage Cache',
      self::VIEW_SYSTEM_HEALTH => 'View System Health',

      self::VIEW_ROLES => 'View Roles',
      self::CREATE_ROLES => 'Create Roles',
      self::EDIT_ROLES => 'Edit Roles',
      self::DELETE_ROLES => 'Delete Roles',
      self::MANAGE_ROLE_PERMISSIONS => 'Manage Role Permissions',

      self::VIEW_PERMISSIONS => 'View Permissions',
      self::MANAGE_PERMISSIONS => 'Manage Permissions',

      self::EDIT_OWN_PROFILE => 'Edit Own Profile',
      self::VIEW_OWN_PROFILE => 'View Own Profile',
      self::EDIT_USER_PROFILE => 'Edit User Profile',
      self::VIEW_USER_PROFILE => 'View User Profile',
      self::CHANGE_USER_PASSWORD => 'Change User Password',
      self::VIEW_USER_ACTIVITY => 'View User Activity',

      self::VIEW_PENDING_USERS => 'View Pending Users',
      self::VERIFY_USERS => 'Verify Users',
      self::APPROVE_USERS => 'Approve Users',
      self::REJECT_USERS => 'Reject Users',
      self::MANAGE_VERIFICATION => 'Manage Verification',

      self::VIEW_ACTIVITY_LOGS => 'View Activity Logs',
      self::MANAGE_ACTIVITY_LOGS => 'Manage Activity Logs',
      self::VIEW_AUDIT_TRAIL => 'View Audit Trail',
      self::VIEW_USER_ACTIONS => 'View User Actions',

      self::VIEW_FILES => 'View Files',
      self::UPLOAD_FILES => 'Upload Files',
      self::DELETE_FILES => 'Delete Files',
      self::MANAGE_FILE_STORAGE => 'Manage File Storage',
    };
  }

  /**
   * Get permission description
   */
  public function description(): string
  {
    return match ($this) {
      self::VIEW_USERS => 'View the list of all users in the system',
      self::CREATE_USERS => 'Create new user accounts',
      self::EDIT_USERS => 'Edit user information and details',
      self::DELETE_USERS => 'Delete user accounts from the system',
      self::EXPORT_USERS => 'Export user data to external formats',
      self::MANAGE_USERS_ROLE => 'Assign or change user roles',
      self::BULK_EDIT_USERS => 'Perform bulk operations on multiple users',

      self::VIEW_DASHBOARD => 'Access the main dashboard',
      self::VIEW_STATISTICS => 'View system statistics and metrics',
      self::VIEW_REPORTS => 'View generated reports',
      self::EXPORT_REPORTS => 'Export reports to external formats',
      self::VIEW_ANALYTICS => 'View detailed analytics and insights',

      self::VIEW_SYSTEM_LOGS => 'View system logs and events',
      self::MANAGE_SYSTEM_LOGS => 'Delete or archive system logs',
      self::VIEW_SYSTEM_SETTINGS => 'View system configuration settings',
      self::MANAGE_SYSTEM_SETTINGS => 'Modify system configuration settings',
      self::MANAGE_CACHE => 'Clear and manage application cache',
      self::VIEW_SYSTEM_HEALTH => 'View system health status and diagnostics',

      self::VIEW_ROLES => 'View the list of system roles',
      self::CREATE_ROLES => 'Create new system roles',
      self::EDIT_ROLES => 'Modify existing system roles',
      self::DELETE_ROLES => 'Delete system roles',
      self::MANAGE_ROLE_PERMISSIONS => 'Assign permissions to roles',

      self::VIEW_PERMISSIONS => 'View the list of all permissions',
      self::MANAGE_PERMISSIONS => 'Create, edit, or delete permissions',

      self::EDIT_OWN_PROFILE => 'Edit your own profile information',
      self::VIEW_OWN_PROFILE => 'View your own profile',
      self::EDIT_USER_PROFILE => 'Edit other user profiles',
      self::VIEW_USER_PROFILE => 'View other user profiles',
      self::CHANGE_USER_PASSWORD => 'Change user passwords as administrator',
      self::VIEW_USER_ACTIVITY => 'View user activity and action history',

      self::VIEW_PENDING_USERS => 'View users pending verification',
      self::VERIFY_USERS => 'Mark users as verified',
      self::APPROVE_USERS => 'Approve user requests',
      self::REJECT_USERS => 'Reject user requests',
      self::MANAGE_VERIFICATION => 'Manage verification workflow settings',

      self::VIEW_ACTIVITY_LOGS => 'View user activity logs',
      self::MANAGE_ACTIVITY_LOGS => 'Delete or archive activity logs',
      self::VIEW_AUDIT_TRAIL => 'View system audit trails',
      self::VIEW_USER_ACTIONS => 'View specific user actions and events',

      self::VIEW_FILES => 'View uploaded files and documents',
      self::UPLOAD_FILES => 'Upload new files and documents',
      self::DELETE_FILES => 'Delete files and documents',
      self::MANAGE_FILE_STORAGE => 'Manage file storage settings',
    };
  }
}
