<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ErpValidationException extends Exception {
    public $shortMessage;
    public ?Throwable $exception;

    public function __construct($message= NULL, $code = NULL, Exception $previous = NULL){
        parent::__construct($message, $code, $previous);
        
        $this->shortMessage = $message;
        $this->exception = $previous;
    }
}