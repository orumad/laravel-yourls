<?php

namespace Orumad\Yourls;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Orumad\Yourls\Yourls
 */
class YourlsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-yourls';
    }
}
