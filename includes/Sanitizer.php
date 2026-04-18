<?php

declare(strict_types=1);

namespace SnippetPress;

/**
 * Handles all code sanitization to prevent execution of user-supplied code.
 *
 * Every piece of code displayed by SnippetPress passes through this class
 * to ensure it is rendered as inert text, never as executable HTML/JS/PHP.
 */
final class Sanitizer
{
    /**
     * Sanitize code for safe HTML output.
     *
     * Converts all special characters to their HTML entity equivalents,
     * strips any remaining tags as a defense-in-depth measure, and
     * normalizes line endings.
     */
    public static function sanitizeCode(string $code): string
    {
        // Decode any existing HTML entities first to avoid double-encoding
        $code = html_entity_decode($code, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Normalize line endings
        $code = str_replace(["\r\n", "\r"], "\n", $code);

        // Convert all special characters to HTML entities — this is the
        // primary defense against code execution (XSS, script injection, etc.)
        $code = htmlspecialchars($code, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return $code;
    }

    /**
     * Sanitize a language identifier to prevent injection via the CSS class.
     *
     * Only allows alphanumeric characters, hyphens, and plus signs
     * (needed for languages like C++, C#, F#).
     */
    public static function sanitizeLanguage(string $language): string
    {
        $language = strtolower(trim($language));
        $language = preg_replace('/[^a-z0-9\-+#]/', '', $language);

        if ($language === '' || !Languages::isSupported($language)) {
            return 'plaintext';
        }

        return $language;
    }
}
