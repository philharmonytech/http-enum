<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum;

enum AuthScheme: string
{
    case BASIC = 'Basic';
    case BEARER = 'Bearer';
    case DIGEST = 'Digest';
    case NEGOTIATE = 'Negotiate';
    case HOBA = 'HOBA';
    case MUTUAL = 'Mutual';
    case OAUTH = 'OAuth';

    public function isTokenBased(): bool
    {
        return match ($this) {
            self::BEARER,
            self::OAUTH => true,
            default => false,
        };
    }

    public function isChallengeBased(): bool
    {
        return match ($this) {
            self::BASIC,
            self::DIGEST,
            self::NEGOTIATE,
            self::HOBA,
            self::MUTUAL => true,
            default => false,
        };
    }

    public function isPasswordBased(): bool
    {
        return match ($this) {
            self::BASIC,
            self::DIGEST => true,
            default => false,
        };
    }

    public static function fromHeader(string $header): ?self
    {
        $header = trim($header);

        if ($header === '') {
            return null;
        }

        $scheme = explode(' ', $header, 2)[0];

        return self::tryFromString($scheme);
    }

    public static function fromString(string $scheme): self
    {
        $value = self::tryFromString($scheme);
        if ($value === null) {
            throw new \ValueError(\sprintf('Invalid auth scheme "%s"', $scheme));
        }

        return $value;
    }

    public static function tryFromString(string $scheme): ?self
    {
        $normalized = self::normalize($scheme);

        foreach (self::cases() as $case) {
            if (strtolower($case->value) === $normalized) {
                return $case;
            }
        }

        return null;
    }

    private static function normalize(string $scheme): string
    {
        return strtolower(trim($scheme));
    }
}
