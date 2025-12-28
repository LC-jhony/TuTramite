@props(['active'])


@php
    $classes =
        $active ?? false
            ? 'flex justify-center gap-2 px-4 py-2 mt-2 text-sm font-semibold text-primary-600 bg-gray-500/10 rounded-lg transition-colors ml-4'
            : 'flex justify-center gap-2 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-primary-600 dark:text-primary-200 md:ml-4 text-secundary-600 hover:bg-gray-100 hover:text-primary-500 transition-colors duration-200';
@endphp
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
