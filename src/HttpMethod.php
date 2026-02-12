<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum;

use ValueError;

enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case PATCH = 'PATCH';
    case HEAD = 'HEAD';
    case OPTIONS = 'OPTIONS';
    case TRACE = 'TRACE';
    case CONNECT = 'CONNECT';

    public function isSafe(): bool
    {
        return in_array($this, [self::GET, self::HEAD, self::OPTIONS, self::TRACE]);
    }

    public function isIdempotent(): bool
    {
        return in_array($this, [self::GET, self::HEAD, self::PUT, self::DELETE, self::OPTIONS, self::TRACE, self::CONNECT]);
    }

    public static function isValid(string $method): bool
    {
        try {
            self::from($method);
            return true;
        } catch (ValueError) {
            return false;
        }
    }
}
