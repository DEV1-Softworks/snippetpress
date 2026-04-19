=== SnippetPress ===
Contributors: dev1softworks
Tags: code, snippet, syntax highlighting, prism, developer
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 8.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Safely display syntax-highlighted code snippets in WordPress posts and pages.

== Description ==

SnippetPress lets you embed beautifully highlighted code snippets in your WordPress content — safely. All code is HTML-escaped so it is never executed, protecting your site from XSS and script injection.

**Features:**

* **80+ languages supported** — PHP, JavaScript, Python, Ruby, Rust, Go, SQL, CSS, HTML, TypeScript, Kotlin, Swift, Bash, YAML, JSON, GraphQL, and many more.
* **Gutenberg block** — a dedicated block with language selector, line numbers toggle, and optional title bar.
* **Shortcode** — `[snippetpress lang="php"]your code[/snippetpress]` for the Classic Editor.
* **Secure by default** — all code passes through multi-layer sanitization. No user-supplied code is ever executed.
* **Line numbers & line highlighting** — toggle line numbers and highlight specific lines.
* **Prism.js autoloader** — language grammars are loaded on-demand, keeping page weight minimal.
* **Responsive** — code blocks scroll horizontally on small screens.

== Installation ==

1. Download the plugin ZIP from the GitHub Releases page.
2. Go to WordPress Admin → Plugins → Add New → Upload Plugin.
3. Upload the ZIP file and click "Install Now".
4. Activate the plugin.

== Usage ==

= Gutenberg Block =

1. In the block editor, add a new block and search for "SnippetPress Code".
2. Paste your code into the textarea.
3. Select the language from the sidebar panel.
4. Optionally enable line numbers and set a title.

= Shortcode (Classic Editor) =

    [snippetpress lang="python" line_numbers="true" title="hello.py"]
    def greet(name):
        print(f"Hello, {name}!")
    [/snippetpress]

**Attributes:**

* `lang` — Language identifier (default: `plaintext`). See supported languages below.
* `line_numbers` — Show line numbers: `true` or `false` (default: `false`).
* `highlight` — Highlight specific lines, e.g. `1,3-5`.
* `title` — Optional title bar text.

== Changelog ==

= 1.0.0 =
* Initial release.
* Gutenberg block and shortcode support.
* 80+ languages via Prism.js autoloader.
* Security-first design: multi-layer HTML escaping.
