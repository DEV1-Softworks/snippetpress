<?php

/**
 * Plugin Name: SnippetPress
 * Plugin URI:  https://github.com/DEV1-Softworks/snippetpress
 * Description: Safely display syntax-highlighted code snippets in WordPress posts and pages. Supports 50+ languages with Prism.js.
 * Version:     1.0.0
 * Requires at least: 6.0
 * Requires PHP: 8.2
 * Author:      DEV1 Softworks
 * Author URI:  https://github.com/DEV1-Softworks
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: snippetpress
 * Domain Path: /languages
 */

declare(strict_types=1);

namespace SnippetPress;

if (!defined('ABSPATH')) {
    exit;
}

define('SNIPPETPRESS_VERSION', '1.0.0');
define('SNIPPETPRESS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SNIPPETPRESS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SNIPPETPRESS_PLUGIN_BASENAME', plugin_basename(__FILE__));

require_once SNIPPETPRESS_PLUGIN_DIR . 'includes/Sanitizer.php';
require_once SNIPPETPRESS_PLUGIN_DIR . 'includes/Languages.php';
require_once SNIPPETPRESS_PLUGIN_DIR . 'includes/Shortcode.php';
require_once SNIPPETPRESS_PLUGIN_DIR . 'includes/Assets.php';
require_once SNIPPETPRESS_PLUGIN_DIR . 'includes/Block.php';

(new Assets())->register();
(new Shortcode())->register();
(new Block())->register();
