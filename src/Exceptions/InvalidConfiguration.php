<?php

namespace Orumad\Yourls\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function serverUrlNotSpecified()
    {
        return new static('There was no YOURLS server url specified. You must provide a valid server url to shorten urls.');
    }

    public static function signatureTokenNotSpecified()
    {
        return new static("There was no YOURLS signature token specified. You must provide a valid token to shorten urls.");
    }

}
