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
    case PROTBUF = 'application/protobuf';

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

    public function isTextBased(): bool
    {
        return str_starts_with($this->value, 'text/') ||
            \in_array($this, [self::JSON, self::JAVASCRIPT, self::XML, self::CSV, self::MARKDOWN,], true);
    }

    public function isJson(): bool
    {
        return $this->value === 'application/json'
            || str_ends_with($this->value, '+json');
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
                self::PROTBUF,
                self::OCTET_STREAM,
            ], true);
    }

    public static function fromHeader(string $header): ?self
    {
        $type = strtolower(trim(explode(';', $header)[0] ?? ''));
        foreach (self::cases() as $case) {
            if ($case->value === $type) {
                return $case;
            }
        }
        return null;
    }

    public static function fromExtension(string $extension): ?self
    {
        return match (strtolower($extension)) {
            'txt' => self::TEXT,
            'html', 'htm' => self::HTML,
            'xml' => self::XML,
            'css' => self::CSS,
            'js' => self::JAVASCRIPT,
            'csv' => self::CSV,
            'md' => self::MARKDOWN,
            'json' => self::JSON,
            'pdf' => self::PDF,
            'zip' => self::ZIP,
            'png' => self::PNG,
            'jpg', 'jpeg' => self::JPEG,
            'gif' => self::GIF,
            'webp' => self::WEBP,
            'svg' => self::SVG,
            'ico' => self::ICON,
            'heic' => self::HEIC,
            'mp3' => self::MP3,
            'wav' => self::WAV,
            'mp4' => self::MP4,
            'mpeg', 'mpg' => self::MPEG,
            'webm' => self::WEBM,
            'woff' => self::WOFF,
            'woff2' => self::WOFF2,
            'ttf' => self::TTF,
            'otf' => self::OTF,
            default => null,
        };
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
}
