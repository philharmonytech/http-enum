<?php

declare(strict_types=1);

namespace Philharmony\Http\Tests\Enum;

use Philharmony\Http\Enum\ContentType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ValueError;

/**
 * @psalm-suppress UnusedClass
 */
class ContentTypeTest extends TestCase
{
    public function testFromReturnsCorrectCase(): void
    {
        $this->assertSame(ContentType::JSON, ContentType::from('application/json'));
        $this->assertSame(ContentType::PNG, ContentType::from('image/png'));
    }

    public function testFromIsCaseSensitive(): void
    {
        $this->expectException(ValueError::class);
        ContentType::from('TEXT/XML');
    }

    public function testTryFromReturnsNullForInvalidValues(): void
    {
        $invalid = ['text', '', 'application/jsons', 'invalid/type', 'TEXT/XML',];
        foreach ($invalid as $value) {
            $this->assertNull(ContentType::tryFrom($value));
        }
    }

    public function testFromThrowsOnInvalidValue(): void
    {
        $this->expectException(ValueError::class);
        ContentType::from('INVALID');
    }

    public function testIsTextBasedReturnsTrueForTextBasedTypes(): void
    {
        foreach (ContentType::textBased() as $type) {
            $this->assertTrue($type->isTextBased());
        }

        foreach (ContentType::cases() as $case) {
            if (!in_array($case, ContentType::textBased(), true)) {
                $this->assertFalse($case->isTextBased());
            }
        }
    }

    public function testIsJsonReturnsTrueForJsonTypes(): void
    {
        foreach (ContentType::json() as $type) {
            $this->assertTrue($type->isJson());
        }

        foreach (ContentType::cases() as $case) {
            if (!in_array($case, ContentType::json(), true)) {
                $this->assertFalse($case->isJson());
            }
        }
    }

    public function testIsImageReturnsTrueForImageTypes(): void
    {
        foreach (ContentType::image() as $type) {
            $this->assertTrue($type->isImage());
        }

        foreach (ContentType::cases() as $case) {
            if (!in_array($case, ContentType::image(), true)) {
                $this->assertFalse($case->isImage());
            }
        }
    }

    public function testIsAudioReturnsTrueForAudioTypes(): void
    {
        foreach (ContentType::audio() as $type) {
            $this->assertTrue($type->isAudio());
        }

        foreach (ContentType::cases() as $case) {
            if (!in_array($case, ContentType::audio(), true)) {
                $this->assertFalse($case->isAudio());
            }
        }
    }

    public function testIsVideoReturnsTrueForVideoTypes(): void
    {
        foreach (ContentType::video() as $type) {
            $this->assertTrue($type->isVideo());
        }

        foreach (ContentType::cases() as $case) {
            if (!in_array($case, ContentType::video(), true)) {
                $this->assertFalse($case->isVideo());
            }
        }
    }

    public function testIsMediaReturnsTrueForMediaTypes(): void
    {
        foreach (ContentType::media() as $type) {
            $this->assertTrue($type->isMedia());
        }

        foreach (ContentType::cases() as $case) {
            if (!in_array($case, ContentType::media(), true)) {
                $this->assertFalse($case->isMedia());
            }
        }
    }

    public function testIsFontReturnsTrueForFontTypes(): void
    {
        foreach (ContentType::font() as $type) {
            $this->assertTrue($type->isFont());
        }

        foreach (ContentType::cases() as $case) {
            if (!in_array($case, ContentType::font(), true)) {
                $this->assertFalse($case->isFont());
            }
        }
    }

    public function testIsFormReturnsTrueForFormTypes(): void
    {
        foreach (ContentType::form() as $type) {
            $this->assertTrue($type->isForm());
        }

        foreach (ContentType::cases() as $case) {
            if (!in_array($case, ContentType::form(), true)) {
                $this->assertFalse($case->isForm());
            }
        }
    }

    public function testIsBinaryReturnsTrueForBinaryTypes(): void
    {
        foreach (ContentType::binary() as $type) {
            $this->assertTrue($type->isBinary());
        }

        foreach (ContentType::cases() as $case) {
            if (!in_array($case, ContentType::binary(), true)) {
                $this->assertFalse($case->isBinary());
            }
        }
    }

    #[DataProvider('getExtensionDataProvider')]
    public function testFromExtensionReturnsCorrectType(
        string $extension,
        ?ContentType $expectedContentType
    ): void {
        $this->assertSame($expectedContentType, ContentType::fromExtension($extension));
    }

    /**
     * @return array<string, array{extension: string, expectedContentType: ContentType|null}>
     */
    public static function getExtensionDataProvider(): array
    {
        return [
            'Lower png extension' => [
                'extension' => 'png',
                'expectedContentType' => ContentType::PNG,
            ],
            'Upper png extension' => [
                'extension' => 'PNG',
                'expectedContentType' => ContentType::PNG,
            ],
            'Lower jpg extension' => [
                'extension' => 'jpg',
                'expectedContentType' => ContentType::JPEG,
            ],
            'Upper jpg extension' => [
                'extension' => 'JPG',
                'expectedContentType' => ContentType::JPEG,
            ],
            'Lower jpeg extension' => [
                'extension' => 'jpeg',
                'expectedContentType' => ContentType::JPEG,
            ],
            'Upper jpeg extension' => [
                'extension' => 'JPEG',
                'expectedContentType' => ContentType::JPEG,
            ],
            'Lower gif extension' => [
                'extension' => 'gif',
                'expectedContentType' => ContentType::GIF,
            ],
            'Upper gif extension' => [
                'extension' => 'GIF',
                'expectedContentType' => ContentType::GIF,
            ],
            'Lower webp extension' => [
                'extension' => 'webp',
                'expectedContentType' => ContentType::WEBP,
            ],
            'Upper webp extension' => [
                'extension' => 'WEBP',
                'expectedContentType' => ContentType::WEBP,
            ],
            'Lower svg extension' => [
                'extension' => 'svg',
                'expectedContentType' => ContentType::SVG,
            ],
            'Upper svg extension' => [
                'extension' => 'SVG',
                'expectedContentType' => ContentType::SVG,
            ],
            'Lower ico extension' => [
                'extension' => 'ico',
                'expectedContentType' => ContentType::ICON,
            ],
            'Upper ico extension' => [
                'extension' => 'ICO',
                'expectedContentType' => ContentType::ICON,
            ],
            'Lower heic extension' => [
                'extension' => 'heic',
                'expectedContentType' => ContentType::HEIC,
            ],
            'Upper heic extension' => [
                'extension' => 'HEIC',
                'expectedContentType' => ContentType::HEIC,
            ],

            'Lower mp3 extension' => [
                'extension' => 'mp3',
                'expectedContentType' => ContentType::MP3,
            ],
            'Upper mp3 extension' => [
                'extension' => 'MP3',
                'expectedContentType' => ContentType::MP3,
            ],
            'Lower wav extension' => [
                'extension' => 'wav',
                'expectedContentType' => ContentType::WAV,
            ],
            'Upper wav extension' => [
                'extension' => 'WAV',
                'expectedContentType' => ContentType::WAV,
            ],

            'Lower mp4 extension' => [
                'extension' => 'mp4',
                'expectedContentType' => ContentType::MP4,
            ],
            'Upper mp4 extension' => [
                'extension' => 'MP4',
                'expectedContentType' => ContentType::MP4,
            ],
            'Lower mpeg extension' => [
                'extension' => 'mpeg',
                'expectedContentType' => ContentType::MPEG,
            ],
            'Upper mpeg extension' => [
                'extension' => 'MPEG',
                'expectedContentType' => ContentType::MPEG,
            ],
            'Lower mpg extension' => [
                'extension' => 'mpg',
                'expectedContentType' => ContentType::MPEG,
            ],
            'Upper mpg extension' => [
                'extension' => 'MPG',
                'expectedContentType' => ContentType::MPEG,
            ],
            'Lower webm extension' => [
                'extension' => 'webm',
                'expectedContentType' => ContentType::WEBM,
            ],
            'Upper webm extension' => [
                'extension' => 'WEBM',
                'expectedContentType' => ContentType::WEBM,
            ],

            'Lower woff extension' => [
                'extension' => 'woff',
                'expectedContentType' => ContentType::WOFF,
            ],
            'Upper woff extension' => [
                'extension' => 'WOFF',
                'expectedContentType' => ContentType::WOFF,
            ],
            'Lower woff2 extension' => [
                'extension' => 'woff2',
                'expectedContentType' => ContentType::WOFF2,
            ],
            'Upper woff2 extension' => [
                'extension' => 'WOFF2',
                'expectedContentType' => ContentType::WOFF2,
            ],
            'Lower ttf extension' => [
                'extension' => 'ttf',
                'expectedContentType' => ContentType::TTF,
            ],
            'Upper ttf extension' => [
                'extension' => 'TTF',
                'expectedContentType' => ContentType::TTF,
            ],
            'Lower otf extension' => [
                'extension' => 'otf',
                'expectedContentType' => ContentType::OTF,
            ],
            'Upper otf extension' => [
                'extension' => 'OTF',
                'expectedContentType' => ContentType::OTF,
            ],

            'Lower txt extension' => [
                'extension' => 'txt',
                'expectedContentType' => ContentType::TEXT,
            ],
            'Upper txt extension' => [
                'extension' => 'TXT',
                'expectedContentType' => ContentType::TEXT,
            ],
            'Lower html extension' => [
                'extension' => 'html',
                'expectedContentType' => ContentType::HTML,
            ],
            'Upper html extension' => [
                'extension' => 'HTML',
                'expectedContentType' => ContentType::HTML,
            ],
            'Lower htm extension' => [
                'extension' => 'htm',
                'expectedContentType' => ContentType::HTML,
            ],
            'Upper htm extension' => [
                'extension' => 'HTM',
                'expectedContentType' => ContentType::HTML,
            ],
            'Lower xml extension' => [
                'extension' => 'xml',
                'expectedContentType' => ContentType::XML,
            ],
            'Upper xml extension' => [
                'extension' => 'XML',
                'expectedContentType' => ContentType::XML,
            ],
            'Lower css extension' => [
                'extension' => 'css',
                'expectedContentType' => ContentType::CSS,
            ],
            'Upper css extension' => [
                'extension' => 'CSS',
                'expectedContentType' => ContentType::CSS,
            ],
            'Lower js extension' => [
                'extension' => 'js',
                'expectedContentType' => ContentType::JAVASCRIPT,
            ],
            'Upper js extension' => [
                'extension' => 'JS',
                'expectedContentType' => ContentType::JAVASCRIPT,
            ],
            'Lower csv extension' => [
                'extension' => 'csv',
                'expectedContentType' => ContentType::CSV,
            ],
            'Upper csv extension' => [
                'extension' => 'CSV',
                'expectedContentType' => ContentType::CSV,
            ],
            'Lower md extension' => [
                'extension' => 'md',
                'expectedContentType' => ContentType::MARKDOWN,
            ],
            'Upper md extension' => [
                'extension' => 'MD',
                'expectedContentType' => ContentType::MARKDOWN,
            ],
            'Lower json extension' => [
                'extension' => 'json',
                'expectedContentType' => ContentType::JSON,
            ],
            'Upper json extension' => [
                'extension' => 'JSON',
                'expectedContentType' => ContentType::JSON,
            ],
            'Lower pdf extension' => [
                'extension' => 'pdf',
                'expectedContentType' => ContentType::PDF,
            ],
            'Upper pdf extension' => [
                'extension' => 'PDF',
                'expectedContentType' => ContentType::PDF,
            ],
            'Lower zip extension' => [
                'extension' => 'zip',
                'expectedContentType' => ContentType::ZIP,
            ],
            'Upper zip extension' => [
                'extension' => 'ZIP',
                'expectedContentType' => ContentType::ZIP,
            ],

            'Lower unknown extension' => [
                'extension' => 'unknown',
                'expectedContentType' => null,
            ],
            'Upper unknown extension' => [
                'extension' => 'UNKNOWN',
                'expectedContentType' => null,
            ],
            'Random extension' => [
                'extension' => 'xyz',
                'expectedContentType' => null,
            ],
            'Empty string extension' => [
                'extension' => '',
                'expectedContentType' => null,
            ],
        ];
    }

    public function testFromHeaderParsesTypeCorrectly(): void
    {
        $this->assertSame(ContentType::JSON, ContentType::fromHeader('application/json; charset=utf-8'));
        $this->assertSame(ContentType::PNG, ContentType::fromHeader('image/png'));
        $this->assertNull(ContentType::fromHeader('invalid/type'));
        $this->assertNull(ContentType::fromHeader(''));
    }
}
