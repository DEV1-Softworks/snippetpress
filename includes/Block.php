<?php

declare(strict_types=1);

namespace SnippetPress;

/**
 * Registers the SnippetPress Gutenberg block.
 */
final class Block
{
    public function register(): void
    {
        add_action('init', [$this, 'registerBlock']);
    }

    public function registerBlock(): void
    {
        register_block_type(SNIPPETPRESS_PLUGIN_DIR . 'assets/js/block/', [
            'render_callback' => [$this, 'render'],
        ]);
    }

    /**
     * Server-side render for the Gutenberg block.
     *
     * @param array<string, mixed> $attributes
     */
    public function render(array $attributes): string
    {
        $language    = Sanitizer::sanitizeLanguage($attributes['language'] ?? 'plaintext');
        $code        = Sanitizer::sanitizeCode($attributes['code'] ?? '');
        $lineNumbers = (bool) ($attributes['lineNumbers'] ?? false);
        $title       = esc_html($attributes['title'] ?? '');

        if (trim($code) === '') {
            return '';
        }

        $prismClass = Languages::toPrismClass($language);

        $preClasses = ['snippetpress-block'];
        if ($lineNumbers) {
            $preClasses[] = 'line-numbers';
        }

        $titleHtml = '';
        if ($title !== '') {
            $titleHtml = '<div class="snippetpress-title">' . $title . '</div>';
        }

        return sprintf(
            '%s<pre class="%s"><code class="%s">%s</code></pre>',
            $titleHtml,
            esc_attr(implode(' ', $preClasses)),
            esc_attr($prismClass),
            $code
        );
    }
}
