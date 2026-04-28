<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create all permissions - Organized by feature
        $permissions = [
            // ===== USER MANAGEMENT =====
            'view users',              // View user list
            'create users',            // Create new users
            'edit users',              // Edit user data
            'delete users',            // Delete users
            'export users',            // Export user data
            'manage users role',       // Assign/change user roles
            'bulk edit users',         // Bulk operations on users

            // ===== DASHBOARD & STATISTICS =====
            'view dashboard',          // Access main dashboard
            'view statistics',         // View system statistics
            'view reports',            // View reports
            'export reports',          // Export report data
            'view analytics',          // View detailed analytics

            // ===== SYSTEM MANAGEMENT =====
            'view system logs',        // View system logs
            'manage system logs',      // Delete/archive logs
            'view system settings',    // View settings
            'manage system settings',  // Modify settings
            'manage cache',            // Clear/manage cache
            'view system health',      // View system health status

            // ===== ROLE MANAGEMENT =====
            'view roles',              // View roles list
            'create roles',            // Create new roles
            'edit roles',              // Modify existing roles
            'delete roles',            // Delete roles
            'manage role permissions', // Assign permissions to roles

            // ===== PERMISSION MANAGEMENT =====
            'view permissions',        // View permissions list
            'manage permissions',      // Create/edit/delete permissions

            // ===== PROFILE MANAGEMENT =====
            'edit own profile',        // Edit self profile
            'view own profile',        // View self profile
            'edit user profile',       // Edit other user profiles
            'view user profile',       // View other user profiles
            'change user password',    // Change user password (admin)
            'view user activity',      // View user activity logs

            // ===== VERIFICATION & APPROVAL =====
            'view pending users',      // View pending verification users
            'verify users',            // Mark users as verified
            'approve users',           // Approve user requests
            'reject users',            // Reject user requests
            'manage verification',     // Manage verification settings

            // ===== AUDIT & ACTIVITY =====
            'view activity logs',      // View user activity logs
            'manage activity logs',    // Delete/archive activity logs
            'view audit trail',        // View audit/system trail
            'view user actions',       // View specific user actions

            // ===== FILE MANAGEMENT =====
            'view files',              // View uploaded files
            'upload files',            // Upload new files
            'delete files',            // Delete files
            'manage file storage',     // Manage storage settings
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to Admin role (has all permissions)
        $adminRole->syncPermissions(Permission::all());

        // Assign permissions to Manager role (management permissions)
        $managerRole->syncPermissions([
            // Users
            'view users',
            'view user profile',
            'edit user profile',
            'create users',
            'edit users',
            'manage users role',
            'bulk edit users',

            // Dashboard & Reports
            'view dashboard',
            'view statistics',
            'view reports',
            'export reports',
            'view analytics',

            // Verification
            'view pending users',
            'verify users',
            'approve users',

            // Activity & Logs
            'view activity logs',
            'view user activity',
            'view audit trail',

            // Profile
            'edit own profile',
            'view own profile',
            'view user profile',
            'edit user profile',

            // Roles & Permissions (view only)
            'view roles',
            'view permissions',
        ]);

        // Assign permissions to User role (limited self-service permissions)
        $userRole->syncPermissions([
            // Profile (self-service only)
            'edit own profile',
            'view own profile',

            // Dashboard (view only)
            'view dashboard',

            // Activity
            'view user activity',
        ]);

        // Create Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password123'),
                'phone' => '+1234567890',
                'address' => '123 Admin Street',
                'city' => 'Admin City',
                'country' => 'Admin Country',
                'postal_code' => '12345',
                'profile_completion_percentage' => 100,
                'is_active' => true,
                'email_verified_at' => now(),
                'verified_at' => now(),
                'last_login_at' => now()->subHours(2),
            ]
        );
        $adminUser->assignRole('admin');

        // Create Manager User
        $managerUser = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Sarah Manager',
                'password' => bcrypt('password123'),
                'phone' => '+0987654321',
                'address' => '456 Manager Avenue',
                'city' => 'Manager City',
                'country' => 'Manager Country',
                'postal_code' => '54321',
                'profile_completion_percentage' => 85,
                'is_active' => true,
                'email_verified_at' => now(),
                'verified_at' => now(),
                'last_login_at' => now()->subHours(4),
            ]
        );
        $managerUser->assignRole('manager');

        // Create Regular User
        $regularUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password123'),
                'phone' => '+1122334455',
                'address' => '789 User Lane',
                'city' => 'User City',
                'country' => 'User Country',
                'postal_code' => '99999',
                'profile_completion_percentage' => 60,
                'is_active' => true,
                'email_verified_at' => now(),
                'verified_at' => now()->subDays(5),
                'last_login_at' => now()->subHours(12),
            ]
        );
        $regularUser->assignRole('user');

        $this->command->info('✓ 51 comprehensive permissions created successfully');
        $this->command->info('✓ Role-based permission assignments completed');
        $this->command->info('  - Admin: Full access to all features');
        $this->command->info('  - Manager: User management, verification, view reports & analytics');
        $this->command->info('  - User: Profile editing, dashboard view, activity logs only');
        $this->command->info('✓ 3 default users created: admin@example.com, manager@example.com, user@example.com');
        $this->command->info('✓ All users set with password: password123');
    }
}