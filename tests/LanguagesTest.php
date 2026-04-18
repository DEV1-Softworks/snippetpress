<?php

declare(strict_types=1);

namespace SnippetPress\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use SnippetPress\Languages;

final class LanguagesTest extends TestCase
{
    #[Test]
    public function isSupportedReturnsTrueForKnownLanguages(): void
    {
        $this->assertTrue(Languages::isSupported('php'));
        $this->assertTrue(Languages::isSupported('javascript'));
        $this->assertTrue(Languages::isSupported('python'));
        $this->assertTrue(Languages::isSupported('sql'));
        $this->assertTrue(Languages::isSupported('css'));
        $this->assertTrue(Languages::isSupported('markup'));
        $this->assertTrue(Languages::isSupported('plaintext'));
    }

    #[Test]
    public function isSupportedReturnsFalseForUnknownLanguages(): void
    {
        $this->assertFalse(Languages::isSupported('klingon'));
        $this->assertFalse(Languages::isSupported(''));
        $this->assertFalse(Languages::isSupported('PHP')); // case-sensitive
    }

    #[Test]
    public function getAllReturnsNonEmptyArray(): void
    {
        $languages = Languages::getAll();

        $this->assertIsArray($languages);
        $this->assertNotEmpty($languages);
        $this->assertGreaterThan(50, count($languages));
    }

    #[Test]
    public function getAllContainsMajorLanguageCategories(): void
    {
        $languages = Languages::getAll();

        // Programming languages
        $this->assertArrayHasKey('php', $languages);
        $this->assertArrayHasKey('python', $languages);
        $this->assertArrayHasKey('java', $languages);
        $this->assertArrayHasKey('rust', $languages);

        // Markup
        $this->assertArrayHasKey('markup', $languages);
        $this->assertArrayHasKey('css', $languages);
        $this->assertArrayHasKey('markdown', $languages);

        // Query languages
        $this->assertArrayHasKey('sql', $languages);
        $this->assertArrayHasKey('graphql', $languages);

        // Data formats
        $this->assertArrayHasKey('json', $languages);
        $this->assertArrayHasKey('yaml', $languages);

        // DevOps
        $this->assertArrayHasKey('docker', $languages);
        $this->assertArrayHasKey('bash', $languages);
    }

    #[Test]
    public function toPrismClassPrefixesCorrectly(): void
    {
        $this->assertSame('language-php', Languages::toPrismClass('php'));
        $this->assertSame('language-javascript', Languages::toPrismClass('javascript'));
        $this->assertSame('language-plaintext', Languages::toPrismClass('plaintext'));
    }
}
