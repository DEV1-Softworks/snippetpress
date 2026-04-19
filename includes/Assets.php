<?php

declare(strict_types=1);

namespace SnippetPress;

/**
 * Enqueues front-end and editor assets (Prism.js, plugin styles).
 *
 * Uses the Prism.js autoloader plugin so language grammars are fetched
 * on-demand from a CDN — this keeps the plugin ZIP small while still
 * supporting 280+ languages.
 */
final class Assets
{
    private const PRISM_CDN = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0';

    public function register(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueFrontend']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueueEditor']);
    }

    public function enqueueFrontend(): void
    {
        // Prism core theme
        wp_enqueue_style(
            'snippetpress-prism',
            SNIPPETPRESS_PLUGIN_URL . 'assets/css/prism.min.css',
            [],
            SNIPPETPRESS_VERSION
        );

        // Line numbers plugin CSS
        wp_enqueue_style(
            'snippetpress-prism-line-numbers',
            SNIPPETPRESS_PLUGIN_URL . 'assets/css/prism-line-numbers.min.css',
            ['snippetpress-prism'],
            SNIPPETPRESS_VERSION
        );

        // Line highlight plugin CSS
        wp_enqueue_style(
            'snippetpress-prism-line-highlight',
            SNIPPETPRESS_PLUGIN_URL . 'assets/css/prism-line-highlight.min.css',
            ['snippetpress-prism'],
            SNIPPETPRESS_VERSION
        );

        // Plugin styles
        wp_enqueue_style(
            'snippetpress-style',
            SNIPPETPRESS_PLUGIN_URL . 'assets/css/snippetpress.css',
            ['snippetpress-prism'],
            SNIPPETPRESS_VERSION
        );

        // Prism core JS
        wp_enqueue_script(
            'snippetpress-prism',
            SNIPPETPRESS_PLUGIN_URL . 'assets/js/prism.min.js',
            [],
            SNIPPETPRESS_VERSION,
            true
        );

        // Autoloader — loads language grammars from CDN on demand
        wp_enqueue_script(
            'snippetpress-prism-autoloader',
            SNIPPETPRESS_PLUGIN_URL . 'assets/js/prism-autoloader.min.js',
            ['snippetpress-prism'],
            SNIPPETPRESS_VERSION,
            true
        );

        // Line numbers plugin
        wp_enqueue_script(
            'snippetpress-prism-line-numbers',
            SNIPPETPRESS_PLUGIN_URL . 'assets/js/prism-line-numbers.min.js',
            ['snippetpress-prism'],
            SNIPPETPRESS_VERSION,
            true
        );

        // Line highlight plugin
        wp_enqueue_script(
            'snippetpress-prism-line-highlight',
            SNIPPETPRESS_PLUGIN_URL . 'assets/js/prism-line-highlight.min.js',
            ['snippetpress-prism'],
            SNIPPETPRESS_VERSION,
            true
        );

        // Configure autoloader path
        wp_add_inline_script(
            'snippetpress-prism-autoloader',
            'Prism.plugins.autoloader.languages_path = "' . self::PRISM_CDN . '/components/";',
            'after'
        );
    }

    public function enqueueEditor(): void
    {
        wp_enqueue_style(
            'snippetpress-editor',
            SNIPPETPRESS_PLUGIN_URL . 'assets/css/snippetpress-editor.css',
            [],
            SNIPPETPRESS_VERSION
        );
    }
}
