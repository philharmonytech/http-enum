<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum;

enum SameSite: string
{
    case LAX = 'Lax';
    case STRICT = 'Strict';
    case NONE = 'None';

    public function isStrict(): bool
    {
        return $this === self::STRICT;
    }

    public function allowsCrossSite(): bool
    {
        return $this === self::NONE;
    }

    public static function fromString(string $value): self
    {
        return self::from(self::normalize($value));
    }

    public static function tryFromString(string $value): ?self
    {
        return self::tryFrom(self::normalize($value));
    }

    private static function normalize(string $value): string
    {
        $value = strtolower(trim($value));

        return match ($value) {
            'lax' => 'Lax',
            'strict' => 'Strict',
            'none' => 'None',
            default => $value,
        };
    }
}
