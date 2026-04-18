<?php

declare(strict_types=1);

namespace SnippetPress\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use SnippetPress\Block;

final class BlockTest extends TestCase
{
    private Block $block;

    protected function setUp(): void
    {
        $this->block = new Block();
    }

    #[Test]
    public function renderProducesValidHtml(): void
    {
        $result = $this->block->render([
            'language' => 'python',
            'code'     => 'print("hello")',
        ]);

        $this->assertStringContainsString('<pre class="snippetpress-block">', $result);
        $this->assertStringContainsString('<code class="language-python">', $result);
    }

    #[Test]
    public function renderEscapesCodeContent(): void
    {
        $result = $this->block->render([
            'language' => 'markup',
            'code'     => '<script>alert("xss")</script>',
        ]);

        $this->assertStringNotContainsString('<script>', $result);
        $this->assertStringContainsString('&lt;script&gt;', $result);
    }

    #[Test]
    public function renderReturnsEmptyForEmptyCode(): void
    {
        $result = $this->block->render([
            'language' => 'php',
            'code'     => '',
        ]);

        $this->assertSame('', $result);
    }

    #[Test]
    public function renderReturnsEmptyForMissingCode(): void
    {
        $result = $this->block->render(['language' => 'php']);

        $this->assertSame('', $result);
    }

    #[Test]
    public function renderDefaultsToPlaintext(): void
    {
        $result = $this->block->render(['code' => 'hello']);

        $this->assertStringContainsString('language-plaintext', $result);
    }

    #[Test]
    public function renderAddsLineNumbersClass(): void
    {
        $result = $this->block->render([
            'code'        => 'hello',
            'lineNumbers' => true,
        ]);

        $this->assertStringContainsString('line-numbers', $result);
    }

    #[Test]
    public function renderShowsTitle(): void
    {
        $result = $this->block->render([
            'code'  => 'hello',
            'title' => 'app.py',
        ]);

        $this->assertStringContainsString('snippetpress-title', $result);
        $this->assertStringContainsString('app.py', $result);
    }

    #[Test]
    public function renderSanitizesMaliciousTitle(): void
    {
        $result = $this->block->render([
            'code'  => 'hello',
            'title' => '<script>alert(1)</script>',
        ]);

        $this->assertStringNotContainsString('<script>', $result);
    }

    #[Test]
    public function renderSanitizesMaliciousLanguage(): void
    {
        $result = $this->block->render([
            'code'     => 'hello',
            'language' => '"><script>alert(1)</script>',
        ]);

        $this->assertStringContainsString('language-plaintext', $result);
        $this->assertStringNotContainsString('<script>', $result);
    }
}
