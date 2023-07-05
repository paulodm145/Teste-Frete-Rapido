<?php

namespace App\Exceptions;

use Exception;

class ServiceException extends Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function render()
    {
        return response()->json([
            'error' => $this->message,
        ], 500);
    }
}
