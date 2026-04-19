<?php

declare(strict_types=1);

/**
 * PHPUnit bootstrap for SnippetPress.
 *
 * Provides lightweight stubs for WordPress functions so unit tests
 * can run without a full WordPress installation.
 */

// Stub WordPress constants
if (!defined('ABSPATH')) {
    define('ABSPATH', '/tmp/wordpress/');
}

if (!defined('SNIPPETPRESS_VERSION')) {
    define('SNIPPETPRESS_VERSION', '1.0.0-test');
}

if (!defined('SNIPPETPRESS_PLUGIN_DIR')) {
    define('SNIPPETPRESS_PLUGIN_DIR', dirname(__DIR__) . '/');
}

if (!defined('SNIPPETPRESS_PLUGIN_URL')) {
    define('SNIPPETPRESS_PLUGIN_URL', 'https://example.com/wp-content/plugins/snippetpress/');
}

if (!defined('SNIPPETPRESS_PLUGIN_BASENAME')) {
    define('SNIPPETPRESS_PLUGIN_BASENAME', 'snippetpress/snippetpress.php');
}

// Stub WordPress functions used by the plugin
if (!function_exists('add_shortcode')) {
    function add_shortcode(string $tag, callable $callback): void
    {
        // no-op for unit tests
    }
}

if (!function_exists('add_action')) {
    function add_action(string $hook, callable $callback, int $priority = 10, int $accepted_args = 1): void
    {
        // no-op for unit tests
    }
}

if (!function_exists('shortcode_atts')) {
    /**
     * @param array<string, mixed> $pairs
     * @param array<string, mixed> $atts
     * @return array<string, mixed>
     */
    function shortcode_atts(array $pairs, array $atts, string $shortcode = ''): array
    {
        $out = [];
        foreach ($pairs as $key => $default) {
            $out[$key] = array_key_exists($key, $atts) ? $atts[$key] : $default;
        }
        return $out;
    }
}

if (!function_exists('esc_html')) {
    function esc_html(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

if (!function_exists('esc_attr')) {
    function esc_attr(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

if (!function_exists('plugin_dir_path')) {
    function plugin_dir_path(string $file): string
    {
        return dirname($file) . '/';
    }
}

if (!function_exists('plugin_dir_url')) {
    function plugin_dir_url(string $file): string
    {
        return 'https://example.com/wp-content/plugins/snippetpress/';
    }
}

if (!function_exists('plugin_basename')) {
    function plugin_basename(string $file): string
    {
        return 'snippetpress/snippetpress.php';
    }
}

if (!function_exists('register_block_type')) {
    function register_block_type(string $block_type, array $args = []): void
    {
        // no-op for unit tests
    }
}

if (!function_exists('wp_enqueue_style')) {
    function wp_enqueue_style(string $handle, string $src = '', array $deps = [], string|false|null $ver = false, string $media = 'all'): void
    {
        // no-op
    }
}

if (!function_exists('wp_enqueue_script')) {
    function wp_enqueue_script(string $handle, string $src = '', array $deps = [], string|false|null $ver = false, bool|array $in_footer = false): void
    {
        // no-op
    }
}

if (!function_exists('wp_add_inline_script')) {
    function wp_add_inline_script(string $handle, string $data, string $position = 'after'): void
    {
        // no-op
    }
}

// Load plugin classes
require_once SNIPPETPRESS_PLUGIN_DIR . 'includes/Sanitizer.php';
require_once SNIPPETPRESS_PLUGIN_DIR . 'includes/Languages.php';
require_once SNIPPETPRESS_PLUGIN_DIR . 'includes/Shortcode.php';
require_once SNIPPETPRESS_PLUGIN_DIR . 'includes/Assets.php';
require_once SNIPPETPRESS_PLUGIN_DIR . 'includes/Block.php';
