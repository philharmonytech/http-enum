<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum;

enum ContentType: string
{
    case TEXT = 'text/plain';
    case HTML = 'text/html';
    case XML = 'application/xml';
    case CSS = 'text/css';
    case JAVASCRIPT = 'application/javascript';
    case CSV = 'text/csv';
    case MARKDOWN = 'text/markdown';

    case JSON = 'application/json';
    case JSON_API = 'application/vnd.api+json';
    case JSON_SCHEMA = 'application/schema+json';
    case HAL_JSON = 'application/hal+json';
    case PROBLEM_JSON = 'application/problem+json';
    case CLOUDEVENTS_JSON = 'application/cloudevents+json';

    case FORM_URLENCODED = 'application/x-www-form-urlencoded';
    case FORM_DATA = 'multipart/form-data';

    case PDF = 'application/pdf';
    case ZIP = 'application/zip';
    case OCTET_STREAM = 'application/octet-stream';
    case MSGPACK = 'application/msgpack';
    case PROTOBUF = 'application/protobuf';

    case PNG = 'image/png';
    case JPEG = 'image/jpeg';
    case GIF = 'image/gif';
    case WEBP = 'image/webp';
    case SVG = 'image/svg+xml';
    case ICON = 'image/x-icon';
    case HEIC = 'image/heic';

    case MP3 = 'audio/mpeg';
    case WAV = 'audio/wav';
    case MP4 = 'video/mp4';
    case MPEG = 'video/mpeg';
    case WEBM = 'video/webm';

    case ATOM = 'application/atom+xml';
    case RSS = 'application/rss+xml';
    case XHTML = 'application/xhtml+xml';
    case EVENT_STREAM = 'text/event-stream';

    case WOFF = 'font/woff';
    case WOFF2 = 'font/woff2';
    case TTF = 'font/ttf';
    case OTF = 'font/otf';

    /**
     * @var array<string, self>
     */
    private const EXTENSION_MAP = [
        'txt' => self::TEXT,
        'html' => self::HTML,
        'htm' => self::HTML,
        'xml' => self::XML,
        'css' => self::CSS,
        'js' => self::JAVASCRIPT,
        'csv' => self::CSV,
        'md' => self::MARKDOWN,
        'json' => self::JSON,
        'pdf' => self::PDF,
        'zip' => self::ZIP,
        'png' => self::PNG,
        'jpg' => self::JPEG,
        'jpeg' => self::JPEG,
        'gif' => self::GIF,
        'webp' => self::WEBP,
        'svg' => self::SVG,
        'ico' => self::ICON,
        'heic' => self::HEIC,
        'mp3' => self::MP3,
        'wav' => self::WAV,
        'mp4' => self::MP4,
        'mpeg' => self::MPEG,
        'mpg' => self::MPEG,
        'webm' => self::WEBM,
        'woff' => self::WOFF,
        'woff2' => self::WOFF2,
        'ttf' => self::TTF,
        'otf' => self::OTF,
    ];

    public function isTextBased(): bool
    {
        return str_starts_with($this->value, 'text/')
            || $this->isJson()
            || $this->isXml()
            || $this === self::JAVASCRIPT;
    }

    public function isJson(): bool
    {
        return $this === self::JSON
            || str_ends_with($this->value, '+json');
    }

    public function isXml(): bool
    {
        return $this === self::XML
            || str_ends_with($this->value, '+xml');
    }

    public function isImage(): bool
    {
        return str_starts_with($this->value, 'image/');
    }

    public function isAudio(): bool
    {
        return str_starts_with($this->value, 'audio/');
    }

    public function isVideo(): bool
    {
        return str_starts_with($this->value, 'video/');
    }

    public function isMedia(): bool
    {
        return $this->isImage() || $this->isAudio() || $this->isVideo();
    }

    public function isFont(): bool
    {
        return str_starts_with($this->value, 'font/');
    }

    public function isForm(): bool
    {
        return \in_array($this, [self::FORM_URLENCODED, self::FORM_DATA,], true);
    }

    public function isBinary(): bool
    {
        return $this->isMedia()
            || $this->isFont()
            || \in_array($this, [
                self::PDF,
                self::ZIP,
                self::MSGPACK,
                self::PROTOBUF,
                self::OCTET_STREAM,
            ], true);
    }

    public function isScript(): bool
    {
        return $this === self::JAVASCRIPT;
    }

    public function isArchive(): bool
    {
        return $this === self::ZIP;
    }

    public function baseType(): string
    {
        $type = explode('/', $this->value)[1];

        if (str_contains($type, '+')) {
            return explode('+', $type)[1];
        }

        return $type;
    }

    public function category(): string
    {
        return explode('/', $this->value, 2)[0];
    }

    public function is(string $type): bool
    {
        return strcasecmp($this->value, $type) === 0;
    }

    public function matches(string $pattern): bool
    {
        if ($pattern === '*/*') {
            return true;
        }

        if (str_ends_with($pattern, '/*')) {
            $prefix = substr($pattern, 0, -1);
            return str_starts_with($this->value, $prefix);
        }

        return $this->value === $pattern;
    }

    public function isCompressible(): bool
    {
        return $this->isTextBased()
            || $this->isJson()
            || $this->isXml()
            || $this === self::JAVASCRIPT;
    }

    public function defaultCharset(): ?string
    {
        return $this->isTextBased() || $this->isJson() || $this->isXml()
            ? 'utf-8'
            : null;
    }

    public static function fromHeader(string $header): ?self
    {
        $type = strtolower(trim(explode(';', $header, 2)[0]));

        return self::tryFrom($type);
    }

    public static function fromFilename(string $filename): ?self
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if ($extension === '') {
            return null;
        }

        return self::fromExtension($extension);
    }

    /**
     * @param ContentType[] $available
     */
    public static function negotiate(string $accept, array $available): ?self
    {
        $accept = trim($accept);
        if ($accept === '' || $available === []) {
            return null;
        }

        $parts = array_map('trim', explode(',', $accept));
        $candidates = [];

        foreach ($parts as $index => $part) {
            if ($part === '') {
                continue;
            }

            $segments = array_map('trim', explode(';', $part));
            $mime = strtolower($segments[0] ?? '');
            if ($mime === '') {
                continue;
            }

            $q = 1.0;
            foreach (\array_slice($segments, 1) as $segment) {
                if (str_starts_with($segment, 'q=')) {
                    $qValue = (float) substr($segment, 2);
                    $q = max(0.0, min(1.0, $qValue));
                    break;
                }
            }

            $candidates[] = [
                'mime' => $mime,
                'q' => $q,
                'pos' => $index,
                'specificity' => self::acceptSpecificity($mime),
            ];
        }

        usort($candidates, static function (array $a, array $b): int {
            if ($a['q'] === $b['q']) {
                if ($a['specificity'] === $b['specificity']) {
                    return $a['pos'] <=> $b['pos'];
                }
                return $a['specificity'] < $b['specificity'] ? 1 : -1;
            }
            return $a['q'] < $b['q'] ? 1 : -1;
        });

        foreach ($candidates as $candidate) {
            foreach ($available as $type) {
                if ($type->matches($candidate['mime'])) {
                    return $type;
                }
            }
        }

        return null;
    }

    public static function fromExtension(string $extension): ?self
    {
        $extension = strtolower(ltrim($extension, '.'));

        return self::EXTENSION_MAP[$extension] ?? null;
    }

    /**
     * @return ContentType[]
     */
    public static function textBased(): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->isTextBased()));
    }

    /**
     * @return ContentType[]
     */
    public static function json(): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->isJson()));
    }

    /**
     * @return ContentType[]
     */
    public static function xml(): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->isXml()));
    }

    /**
     * @return ContentType[]
     */
    public static function image(): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->isImage()));
    }

    /**
     * @return ContentType[]
     */
    public static function audio(): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->isAudio()));
    }

    /**
     * @return ContentType[]
     */
    public static function video(): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->isVideo()));
    }

    /**
     * @return ContentType[]
     */
    public static function media(): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->isMedia()));
    }

    /**
     * @return ContentType[]
     */
    public static function font(): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->isFont()));
    }

    /**
     * @return ContentType[]
     */
    public static function form(): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->isForm()));
    }

    /**
     * @return ContentType[]
     */
    public static function binary(): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->isBinary()));
    }

    private static function acceptSpecificity(string $mime): int
    {
        if ($mime === '*/*') {
            return 0;
        }
        if (str_ends_with($mime, '/*')) {
            return 1;
        }
        return 2;
    }
}
