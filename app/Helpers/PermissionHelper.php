<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    /**
     * Check if current user is admin
     */
    public static function isAdmin(): bool
    {
        return Auth::check() && Auth::user()->hasRole('admin');
    }

    /**
     * Check if current user can manage books
     */
    public static function canManageBooks(): bool
    {
        return Auth::check() && (
            Auth::user()->hasRole('admin') ||
            Auth::user()->can('manage books')
        );
    }

    /**
     * Check if current user can manage categories
     */
    public static function canManageCategories(): bool
    {
        return Auth::check() && Auth::user()->hasRole('admin');
    }

    /**
     * Check if current user can manage members
     */
    public static function canManageMembers(): bool
    {
        return Auth::check() && Auth::user()->hasRole('admin');
    }

    /**
     * Check if current user can manage borrowing
     */
    public static function canManageBorrowing(): bool
    {
        return Auth::check() && (
            Auth::user()->hasRole('admin') ||
            Auth::user()->can('manage borrowing')
        );
    }
}
