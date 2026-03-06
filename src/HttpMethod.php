<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum;

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
        return match ($this) {
            self::GET,
            self::HEAD,
            self::OPTIONS,
            self::TRACE => true,
            default => false,
        };
    }

    public function isIdempotent(): bool
    {
        return match ($this) {
            self::GET,
            self::HEAD,
            self::PUT,
            self::DELETE,
            self::OPTIONS,
            self::TRACE,
            self::CONNECT => true,
            default => false,
        };
    }

    public function isCacheable(): bool
    {
        return match ($this) {
            self::GET,
            self::HEAD => true,
            default => false,
        };
    }

    public function isReadOnly(): bool
    {
        return $this->isSafe();
    }

    public function isWriteOnly(): bool
    {
        return !$this->isReadOnly();
    }

    public function usuallyHasBody(): bool
    {
        return match ($this) {
            self::POST,
            self::PUT,
            self::PATCH => true,
            default => false,
        };
    }

    public function allowsBody(): bool
    {
        return match ($this) {
            self::POST,
            self::PUT,
            self::PATCH,
            self::DELETE => true,
            default => false,
        };
    }

    public static function fromString(string $method): self
    {
        return self::from(strtoupper($method));
    }

    public static function tryFromString(string $method): ?self
    {
        return self::tryFrom(strtoupper($method));
    }

    public static function isValid(string $method): bool
    {
        return self::tryFromString($method) !== null;
    }
}
