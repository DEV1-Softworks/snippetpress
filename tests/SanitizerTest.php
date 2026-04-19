<?php

declare(strict_types=1);

namespace SnippetPress\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use SnippetPress\Sanitizer;

final class SanitizerTest extends TestCase
{
    // ── sanitizeCode ─────────────────────────────────────────────

    #[Test]
    public function sanitizeCodeEscapesHtmlTags(): void
    {
        $input    = '<script>alert("xss")</script>';
        $expected = '&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;';

        $this->assertSame($expected, Sanitizer::sanitizeCode($input));
    }

    #[Test]
    public function sanitizeCodeEscapesPhpTags(): void
    {
        $input    = '<?php echo "pwned"; ?>';
        $expected = '&lt;?php echo &quot;pwned&quot;; ?&gt;';

        $this->assertSame($expected, Sanitizer::sanitizeCode($input));
    }

    #[Test]
    public function sanitizeCodeHandlesAmpersands(): void
    {
        $input    = 'if (a && b) { return a & b; }';
        $expected = 'if (a &amp;&amp; b) { return a &amp; b; }';

        $this->assertSame($expected, Sanitizer::sanitizeCode($input));
    }

    #[Test]
    public function sanitizeCodeEscapesSingleQuotes(): void
    {
        $input = "echo 'hello';";
        $result = Sanitizer::sanitizeCode($input);

        // PHP may encode as &#039; or &apos; depending on version — both are safe
        $this->assertTrue(
            str_contains($result, '&#039;') || str_contains($result, '&apos;'),
            'Single quotes must be HTML-encoded'
        );
    }

    #[Test]
    public function sanitizeCodeNormalizesLineEndings(): void
    {
        $input = "line1\r\nline2\rline3\nline4";

        $result = Sanitizer::sanitizeCode($input);

        $this->assertStringNotContainsString("\r", $result);
        $this->assertSame("line1\nline2\nline3\nline4", $result);
    }

    #[Test]
    public function sanitizeCodePreventsDoubleEncoding(): void
    {
        $input = '&lt;div&gt;already encoded&lt;/div&gt;';
        $result = Sanitizer::sanitizeCode($input);

        // Should decode first, then re-encode — no double entities
        $this->assertSame('&lt;div&gt;already encoded&lt;/div&gt;', $result);
    }

    #[Test]
    public function sanitizeCodeHandlesEmptyString(): void
    {
        $this->assertSame('', Sanitizer::sanitizeCode(''));
    }

    #[Test]
    public function sanitizeCodeHandlesMultibyteCharacters(): void
    {
        $input = 'const greeting = "こんにちは"; // Japanese';
        $result = Sanitizer::sanitizeCode($input);

        $this->assertStringContainsString('こんにちは', $result);
    }

    #[Test]
    public function sanitizeCodeBlocksEventHandlers(): void
    {
        $input = '<img src=x onerror="alert(1)">';
        $result = Sanitizer::sanitizeCode($input);

        // The tag must be fully escaped — no raw HTML tags
        $this->assertStringNotContainsString('<img', $result);
        $this->assertStringContainsString('&lt;img', $result);
        // The attribute is present as inert text, not executable HTML
        $this->assertStringNotContainsString('="alert', $result);
    }

    #[Test]
    public function sanitizeCodeBlocksJavascriptProtocol(): void
    {
        $input = '<a href="javascript:alert(1)">click</a>';
        $result = Sanitizer::sanitizeCode($input);

        $this->assertStringNotContainsString('<a', $result);
        $this->assertStringContainsString('&lt;a', $result);
    }

    #[Test]
    public function sanitizeCodeBlocksSvgOnload(): void
    {
        $input = '<svg onload="alert(1)">';
        $result = Sanitizer::sanitizeCode($input);

        $this->assertStringNotContainsString('<svg', $result);
    }

    #[Test]
    public function sanitizeCodeBlocksStyleInjection(): void
    {
        $input = '<style>body { display: none; }</style>';
        $result = Sanitizer::sanitizeCode($input);

        $this->assertStringNotContainsString('<style>', $result);
    }

    // ── sanitizeLanguage ─────────────────────────────────────────

    #[Test]
    public function sanitizeLanguageReturnsValidLanguage(): void
    {
        $this->assertSame('php', Sanitizer::sanitizeLanguage('php'));
        $this->assertSame('javascript', Sanitizer::sanitizeLanguage('JavaScript'));
        $this->assertSame('csharp', Sanitizer::sanitizeLanguage('csharp'));
    }

    #[Test]
    public function sanitizeLanguageDefaultsToPlaintext(): void
    {
        $this->assertSame('plaintext', Sanitizer::sanitizeLanguage(''));
        $this->assertSame('plaintext', Sanitizer::sanitizeLanguage('nonexistent'));
        $this->assertSame('plaintext', Sanitizer::sanitizeLanguage('  '));
    }

    #[Test]
    public function sanitizeLanguageStripsInjectionAttempts(): void
    {
        // Attempt CSS class injection
        $this->assertSame('plaintext', Sanitizer::sanitizeLanguage('" onclick="alert(1)'));
        $this->assertSame('plaintext', Sanitizer::sanitizeLanguage('<script>'));
        $this->assertSame('plaintext', Sanitizer::sanitizeLanguage('lang;DROP TABLE'));
    }

    #[Test]
    public function sanitizeLanguageTrimsWhitespace(): void
    {
        $this->assertSame('python', Sanitizer::sanitizeLanguage('  python  '));
    }
}
