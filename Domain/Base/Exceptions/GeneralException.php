<?php

namespace Domain\Base\Exceptions;

use Exception;

class GeneralException extends Exception
{
    protected $code;
    protected $publicMessage;

    public function __construct($message = 'Ocorreu um erro ao executar essa ação.', $code = 400, $publicMessage = null)
    {
        parent::__construct($message, $code);

        $publicMessage = $publicMessage ?? $message;
        $this->publicMessage = $publicMessage;
    }

    public function getPublicMessage()
    {
        return $this->publicMessage;
    }
}
