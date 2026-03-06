<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum;

enum ContentEncoding: string
{
    case GZIP = 'gzip';
    case DEFLATE = 'deflate';
    case BR = 'br';
    case COMPRESS = 'compress';
    case IDENTITY = 'identity';

    public function isCompressed(): bool
    {
        return match ($this) {
            self::GZIP,
            self::DEFLATE,
            self::BR,
            self::COMPRESS => true,
            default => false,
        };
    }

    public static function fromString(string $encoding): self
    {
        return self::from(self::normalize($encoding));
    }

    public static function tryFromString(string $encoding): ?self
    {
        return self::tryFrom(self::normalize($encoding));
    }

    private static function normalize(string $encoding): string
    {
        return strtolower(trim($encoding));
    }
}
