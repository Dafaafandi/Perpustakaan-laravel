<?php

namespace App\Exceptions\Library;

use Exception;

class BookNotFoundException extends Exception
{
    protected $message = 'Buku tidak ditemukan.';
    protected $code = 404;
}
