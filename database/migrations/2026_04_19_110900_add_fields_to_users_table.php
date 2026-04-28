<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      // Additional user profile fields
      $table->string('phone')->nullable()->after('email');
      $table->string('avatar')->nullable()->after('phone');
      $table->text('address')->nullable()->after('avatar');
      $table->string('city')->nullable()->after('address');
      $table->string('country')->nullable()->after('city');
      $table->string('postal_code')->nullable()->after('country');

      // Profile completion tracking
      $table->integer('profile_completion_percentage')->default(0)->after('postal_code');

      // Last login timestamp - using nullable timestamp
      $table->timestamp('last_login_at')->nullable()->after('profile_completion_percentage');

      // Account verification status
      $table->boolean('is_active')->default(true)->after('last_login_at');
      $table->timestamp('verified_at')->nullable()->after('is_active');

      // Additional indexing for optimal query performance
      $table->index('phone');
      $table->index('is_active');
      $table->index('last_login_at');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropIndex(['phone']);
      $table->dropIndex(['is_active']);
      $table->dropIndex(['last_login_at']);

      $table->dropColumn([
        'phone',
        'avatar',
        'address',
        'city',
        'country',
        'postal_code',
        'profile_completion_percentage',
        'last_login_at',
        'is_active',
        'verified_at',
      ]);
    });
  }
};
