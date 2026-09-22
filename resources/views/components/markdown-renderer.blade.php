@props([
    'content' => '',
])

@php
    $markdown = is_string($content) ? $content : (string) $content;
    $html = \Illuminate\Support\Str::markdown($markdown, [
        'html_input' => 'strip',
        'allow_unsafe_links' => false,
        'max_nesting_level' => 20,
        'renderer' => [
            'soft_break' => "<br>\n",
        ],
    ]);
@endphp

<div {{ $attributes->class('markdown-content') }}>
    {!! $html !!}
</div>
