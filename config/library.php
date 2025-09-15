<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Library Application Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration values specific to the library management system
    |
    */

    'name' => 'Perpustakaan Lamongan',

    'version' => '1.0.0',

    'author' => 'Library Management Team',

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings
    |--------------------------------------------------------------------------
    */

    'pagination' => [
        'books' => 15,
        'categories' => 10,
        'members' => 20,
        'borrowings' => 15,
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    */

    'uploads' => [
        'allowed_extensions' => ['xlsx', 'xls', 'csv'],
        'max_file_size' => 2048, // KB
        'path' => 'uploads',
    ],

    /*
    |--------------------------------------------------------------------------
    | Export Settings
    |--------------------------------------------------------------------------
    */

    'exports' => [
        'excel' => [
            'enabled' => true,
            'formats' => ['xlsx', 'csv'],
        ],
        'pdf' => [
            'enabled' => true,
            'paper_size' => 'A4',
            'orientation' => 'portrait',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Borrowing Settings
    |--------------------------------------------------------------------------
    */

    'borrowing' => [
        'max_books_per_user' => -1,
        'default_period_days' => 14,
        'renewal_allowed' => true,
        'max_renewals' => 2,
        'fine_per_day' => false,
        'auto_approve' => true,
        'bypass_stock' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | User Roles
    |--------------------------------------------------------------------------
    */

    'roles' => [
        'admin' => 'Admin',
        'librarian' => 'Pustakawan',
        'member' => 'Anggota',
    ],

    /*
    |--------------------------------------------------------------------------
    | System Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'category' => 'Umum',
        'book_status' => 'available',
        'user_status' => 'active',
    ],
];
