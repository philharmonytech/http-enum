<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum;

enum CacheDirective: string
{
    case NO_CACHE = 'no-cache';
    case NO_STORE = 'no-store';
    case MAX_AGE = 'max-age';
    case S_MAXAGE = 's-maxage';
    case PUBLIC = 'public';
    case PRIVATE = 'private';
    case MUST_REVALIDATE = 'must-revalidate';
    case PROXY_REVALIDATE = 'proxy-revalidate';
    case IMMUTABLE = 'immutable';
    case STALE_WHILE_REVALIDATE = 'stale-while-revalidate';
    case STALE_IF_ERROR = 'stale-if-error';

    public function isRestriction(): bool
    {
        return match ($this) {
            self::NO_CACHE,
            self::NO_STORE => true,
            default => false,
        };
    }

    public function isExpiration(): bool
    {
        return match ($this) {
            self::MAX_AGE,
            self::S_MAXAGE => true,
            default => false,
        };
    }

    public function isVisibility(): bool
    {
        return match ($this) {
            self::PUBLIC,
            self::PRIVATE => true,
            default => false,
        };
    }

    public static function fromString(string $directive): self
    {
        return self::from(self::normalize($directive));
    }

    public static function tryFromString(string $directive): ?self
    {
        return self::tryFrom(self::normalize($directive));
    }

    private static function normalize(string $directive): string
    {
        return strtolower(trim($directive));
    }
}
