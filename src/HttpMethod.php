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

    public function isIdempotent(): bool
    {
        return match ($this) {
            self::GET, self::PUT, self::DELETE, self::HEAD, self::OPTIONS => true,
            self::POST, self::PATCH => false,
        };
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
