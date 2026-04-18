/* global wp */
(function () {
    'use strict';

    const { registerBlockType } = wp.blocks;
    const { useBlockProps, InspectorControls } = wp.blockEditor;
    const { PanelBody, SelectControl, ToggleControl, TextControl, TextareaControl } = wp.components;
    const { createElement: el } = wp.element;
    const { __ } = wp.i18n;

    const LANGUAGES = {
        plaintext: 'Plain Text',
        bash: 'Bash / Shell',
        c: 'C',
        cpp: 'C++',
        csharp: 'C#',
        clojure: 'Clojure',
        coffeescript: 'CoffeeScript',
        crystal: 'Crystal',
        css: 'CSS',
        d: 'D',
        dart: 'Dart',
        diff: 'Diff',
        docker: 'Dockerfile',
        elixir: 'Elixir',
        elm: 'Elm',
        erlang: 'Erlang',
        fortran: 'Fortran',
        fsharp: 'F#',
        go: 'Go',
        graphql: 'GraphQL',
        groovy: 'Groovy',
        handlebars: 'Handlebars',
        haskell: 'Haskell',
        hcl: 'HCL (Terraform)',
        ini: 'INI',
        java: 'Java',
        javascript: 'JavaScript',
        json: 'JSON',
        jsx: 'JSX',
        julia: 'Julia',
        kotlin: 'Kotlin',
        latex: 'LaTeX',
        less: 'Less',
        lisp: 'Lisp',
        lua: 'Lua',
        makefile: 'Makefile',
        markdown: 'Markdown',
        markup: 'HTML / XML',
        matlab: 'MATLAB',
        mongodb: 'MongoDB',
        nasm: 'NASM',
        nginx: 'nginx',
        nim: 'Nim',
        objectivec: 'Objective-C',
        ocaml: 'OCaml',
        pascal: 'Pascal',
        perl: 'Perl',
        php: 'PHP',
        plsql: 'PL/SQL',
        powershell: 'PowerShell',
        prolog: 'Prolog',
        pug: 'Pug',
        python: 'Python',
        r: 'R',
        racket: 'Racket',
        ruby: 'Ruby',
        rust: 'Rust',
        sass: 'Sass',
        scala: 'Scala',
        scheme: 'Scheme',
        scss: 'SCSS',
        sparql: 'SPARQL',
        sql: 'SQL',
        stylus: 'Stylus',
        swift: 'Swift',
        toml: 'TOML',
        tsx: 'TSX',
        twig: 'Twig',
        typescript: 'TypeScript',
        vbnet: 'VB.NET',
        vim: 'Vim Script',
        wasm: 'WebAssembly',
        yaml: 'YAML',
        zig: 'Zig'
    };

    const languageOptions = Object.entries(LANGUAGES).map(function (entry) {
        return { label: entry[1], value: entry[0] };
    });

    registerBlockType('snippetpress/code-block', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var blockProps = useBlockProps({ className: 'snippetpress-editor-block' });

            return el(
                'div',
                blockProps,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Code Settings', 'snippetpress'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Language', 'snippetpress'),
                            value: attributes.language,
                            options: languageOptions,
                            onChange: function (val) { setAttributes({ language: val }); }
                        }),
                        el(ToggleControl, {
                            label: __('Show Line Numbers', 'snippetpress'),
                            checked: attributes.lineNumbers,
                            onChange: function (val) { setAttributes({ lineNumbers: val }); }
                        }),
                        el(TextControl, {
                            label: __('Title (optional)', 'snippetpress'),
                            value: attributes.title,
                            onChange: function (val) { setAttributes({ title: val }); }
                        })
                    )
                ),
                attributes.title
                    ? el('div', { className: 'snippetpress-title' }, attributes.title)
                    : null,
                el(
                    'div',
                    { className: 'snippetpress-editor-header' },
                    el('span', { className: 'snippetpress-lang-badge' }, LANGUAGES[attributes.language] || attributes.language)
                ),
                el(TextareaControl, {
                    className: 'snippetpress-code-input',
                    value: attributes.code,
                    onChange: function (val) { setAttributes({ code: val }); },
                    placeholder: __('Paste your code here…', 'snippetpress'),
                    rows: 12
                })
            );
        },

        save: function () {
            // Server-side rendered
            return null;
        }
    });
})();
