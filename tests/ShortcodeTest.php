<?php

declare(strict_types=1);

namespace SnippetPress\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use SnippetPress\Shortcode;

final class ShortcodeTest extends TestCase
{
    private Shortcode $shortcode;

    protected function setUp(): void
    {
        $this->shortcode = new Shortcode();
    }

    #[Test]
    public function renderProducesValidHtmlStructure(): void
    {
        $result = $this->shortcode->render(
            ['lang' => 'php'],
            'echo "Hello";'
        );

        $this->assertStringContainsString('<pre class="snippetpress-block">', $result);
        $this->assertStringContainsString('<code class="language-php">', $result);
        $this->assertStringContainsString('</code></pre>', $result);
    }

    #[Test]
    public function renderEscapesCodeContent(): void
    {
        $malicious = '<script>alert("xss")</script>';
        $result = $this->shortcode->render(['lang' => 'javascript'], $malicious);

        $this->assertStringNotContainsString('<script>', $result);
        $this->assertStringContainsString('&lt;script&gt;', $result);
    }

    #[Test]
    public function renderReturnsEmptyForNullContent(): void
    {
        $this->assertSame('', $this->shortcode->render(['lang' => 'php'], null));
    }

    #[Test]
    public function renderReturnsEmptyForWhitespaceContent(): void
    {
        $this->assertSame('', $this->shortcode->render(['lang' => 'php'], '   '));
    }

    #[Test]
    public function renderDefaultsToPlaintextLanguage(): void
    {
        $result = $this->shortcode->render([], 'some code');

        $this->assertStringContainsString('language-plaintext', $result);
    }

    #[Test]
    public function renderAddsLineNumbersClass(): void
    {
        $result = $this->shortcode->render(
            ['lang' => 'python', 'line_numbers' => 'true'],
            'print("hi")'
        );

        $this->assertStringContainsString('line-numbers', $result);
    }

    #[Test]
    public function renderOmitsLineNumbersByDefault(): void
    {
        $result = $this->shortcode->render(
            ['lang' => 'python'],
            'print("hi")'
        );

        $this->assertStringNotContainsString('line-numbers', $result);
    }

    #[Test]
    public function renderAddsHighlightDataAttribute(): void
    {
        $result = $this->shortcode->render(
            ['lang' => 'php', 'highlight' => '1,3-5'],
            'line 1'
        );

        $this->assertStringContainsString('data-line="1,3-5"', $result);
    }

    #[Test]
    public function renderSanitizesHighlightAttribute(): void
    {
        $result = $this->shortcode->render(
            ['lang' => 'php', 'highlight' => '1,3<script>alert(1)</script>'],
            'code'
        );

        $this->assertStringNotContainsString('<script>', $result);
        $this->assertStringContainsString('data-line="1,3', $result);
    }

    #[Test]
    public function renderShowsTitle(): void
    {
        $result = $this->shortcode->render(
            ['lang' => 'php', 'title' => 'example.php'],
            'echo 1;'
        );

        $this->assertStringContainsString('<div class="snippetpress-title">example.php</div>', $result);
    }

    #[Test]
    public function renderEscapesTitleXss(): void
    {
        $result = $this->shortcode->render(
            ['lang' => 'php', 'title' => '<img src=x onerror=alert(1)>'],
            'echo 1;'
        );

        $this->assertStringNotContainsString('<img', $result);
    }

    #[Test]
    public function renderHandlesStringAtts(): void
    {
        // WordPress passes an empty string when no attributes are given
        $result = $this->shortcode->render('', 'some code');

        $this->assertStringContainsString('language-plaintext', $result);
    }

    #[Test]
    public function renderPreventsSqlInjectionInLanguage(): void
    {
        $result = $this->shortcode->render(
            ['lang' => "'; DROP TABLE wp_posts; --"],
            'SELECT 1;'
        );

        $this->assertStringContainsString('language-plaintext', $result);
        $this->assertStringNotContainsString('DROP TABLE', $result);
    }
}
