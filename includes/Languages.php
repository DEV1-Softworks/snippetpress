<?php

declare(strict_types=1);

namespace SnippetPress;

/**
 * Registry of supported languages and their Prism.js identifiers.
 */
final class Languages
{
    /**
     * Map of language slug => display name.
     *
     * Keys are Prism.js language identifiers.
     */
    private const SUPPORTED = [
        // General-purpose programming languages
        'bash'         => 'Bash / Shell',
        'c'            => 'C',
        'clike'        => 'C-like',
        'cpp'          => 'C++',
        'csharp'       => 'C#',
        'clojure'      => 'Clojure',
        'cobol'        => 'COBOL',
        'coffeescript'  => 'CoffeeScript',
        'crystal'      => 'Crystal',
        'd'            => 'D',
        'dart'         => 'Dart',
        'elixir'       => 'Elixir',
        'elm'          => 'Elm',
        'erlang'       => 'Erlang',
        'fortran'      => 'Fortran',
        'fsharp'       => 'F#',
        'go'           => 'Go',
        'groovy'       => 'Groovy',
        'haskell'      => 'Haskell',
        'java'         => 'Java',
        'javascript'   => 'JavaScript',
        'julia'        => 'Julia',
        'kotlin'       => 'Kotlin',
        'lisp'         => 'Lisp',
        'lua'          => 'Lua',
        'matlab'       => 'MATLAB',
        'nim'          => 'Nim',
        'objectivec'   => 'Objective-C',
        'ocaml'        => 'OCaml',
        'pascal'       => 'Pascal',
        'perl'         => 'Perl',
        'php'          => 'PHP',
        'powershell'   => 'PowerShell',
        'python'       => 'Python',
        'r'            => 'R',
        'ruby'         => 'Ruby',
        'rust'         => 'Rust',
        'scala'        => 'Scala',
        'scheme'       => 'Scheme',
        'swift'        => 'Swift',
        'typescript'   => 'TypeScript',
        'vbnet'        => 'VB.NET',
        'zig'          => 'Zig',

        // Markup & templating
        'markup'       => 'HTML / XML',
        'css'          => 'CSS',
        'svg'          => 'SVG',
        'mathml'       => 'MathML',
        'latex'        => 'LaTeX',
        'markdown'     => 'Markdown',
        'pug'          => 'Pug',
        'handlebars'   => 'Handlebars',
        'twig'         => 'Twig',
        'jsx'          => 'JSX',
        'tsx'          => 'TSX',

        // Stylesheets
        'less'         => 'Less',
        'sass'         => 'Sass',
        'scss'         => 'SCSS',
        'stylus'       => 'Stylus',

        // Query & data languages
        'sql'          => 'SQL',
        'plsql'        => 'PL/SQL',
        'graphql'      => 'GraphQL',
        'sparql'       => 'SPARQL',
        'mongodb'      => 'MongoDB',

        // Data / config formats
        'json'         => 'JSON',
        'yaml'         => 'YAML',
        'toml'         => 'TOML',
        'ini'          => 'INI',
        'csv'          => 'CSV',

        // DevOps / infrastructure
        'docker'       => 'Dockerfile',
        'nginx'        => 'nginx',
        'apacheconf'   => 'Apache Config',
        'hcl'          => 'HCL (Terraform)',

        // Other
        'regex'        => 'Regular Expressions',
        'git'          => 'Git',
        'diff'         => 'Diff',
        'makefile'     => 'Makefile',
        'ignore'       => '.gitignore / .ignore',
        'plaintext'    => 'Plain Text',

        // Assembly & low-level
        'nasm'         => 'NASM',
        'wasm'         => 'WebAssembly',

        // Functional & academic
        'prolog'       => 'Prolog',
        'racket'       => 'Racket',

        // Scripting
        'awk'          => 'AWK',
        'vim'          => 'Vim Script',
    ];

    public static function isSupported(string $language): bool
    {
        return isset(self::SUPPORTED[$language]);
    }

    /**
     * @return array<string, string> language slug => display name
     */
    public static function getAll(): array
    {
        return self::SUPPORTED;
    }

    /**
     * Return the Prism.js CSS class for the given language.
     */
    public static function toPrismClass(string $language): string
    {
        return 'language-' . $language;
    }
}
