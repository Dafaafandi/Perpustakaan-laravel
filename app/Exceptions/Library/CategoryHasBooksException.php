<?php

namespace App\Exceptions\Library;

use Exception;

class CategoryHasBooksException extends Exception
{
    protected $message = 'Kategori tidak dapat dihapus karena masih memiliki buku.';
    protected $code = 400;
}
