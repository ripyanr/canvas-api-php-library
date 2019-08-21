<?php

namespace Uncgits\CanvasApi\Exceptions;

class CanvasApiException extends \Exception
{
    protected $response;

    public function __construct($message = null, $code = 0, $previous = null, $response = [])
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
        // TODO: augment $message with information from the response message/reason
        // TODO: augment $code with information from the response code.
    }

    public function getResponse()
    {
        return $this->response;
    }
}
