<?php

declare(strict_types=1);

namespace SnippetPress;

/**
 * Registers and renders the [snippetpress] shortcode.
 *
 * Usage:
 *   [snippetpress lang="php" line_numbers="true" highlight="3,5-7"]
 *   echo "Hello, World!";
 *   [/snippetpress]
 */
final class Shortcode
{
    public function register(): void
    {
        add_shortcode('snippetpress', [$this, 'render']);
    }

    /**
     * @param array<string, string>|string $atts
     */
    public function render(array|string $atts, ?string $content = null): string
    {
        $atts = shortcode_atts(
            [
                'lang'         => 'plaintext',
                'line_numbers' => 'false',
                'highlight'    => '',
                'title'        => '',
            ],
            is_array($atts) ? $atts : [],
            'snippetpress'
        );

        if ($content === null || trim($content) === '') {
            return '';
        }

        $language    = Sanitizer::sanitizeLanguage($atts['lang']);
        $prismClass  = Languages::toPrismClass($language);
        $code        = Sanitizer::sanitizeCode($content);
        $lineNumbers = filter_var($atts['line_numbers'], FILTER_VALIDATE_BOOLEAN);
        $highlight   = $this->sanitizeHighlight($atts['highlight']);
        $title       = esc_html($atts['title']);

        $preClasses = ['snippetpress-block'];
        if ($lineNumbers) {
            $preClasses[] = 'line-numbers';
        }

        $dataAttrs = '';
        if ($highlight !== '') {
            $dataAttrs = ' data-line="' . esc_attr($highlight) . '"';
        }

        $titleHtml = '';
        if ($title !== '') {
            $titleHtml = '<div class="snippetpress-title">' . $title . '</div>';
        }

        return sprintf(
            '%s<pre class="%s"%s><code class="%s">%s</code></pre>',
            $titleHtml,
            esc_attr(implode(' ', $preClasses)),
            $dataAttrs,
            esc_attr($prismClass),
            $code
        );
    }

    /**
     * Sanitize line highlight specification.
     *
     * Allows only digits, commas, hyphens (e.g. "1,3,5-8").
     */
    private function sanitizeHighlight(string $highlight): string
    {
        return preg_replace('/[^0-9,\-]/', '', $highlight);
    }
}
