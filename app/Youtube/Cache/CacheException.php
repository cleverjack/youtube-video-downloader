<?php

namespace App\Youtube\Cache;

use Exception;

/**
 * Base exception in a cache.
 *
 * This interface must be compatible with PSR-16 Psr\SimpleCache\CacheException
 */
class CacheException extends Exception
{
}
