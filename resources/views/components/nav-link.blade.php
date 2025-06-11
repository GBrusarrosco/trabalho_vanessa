@props(['active'])

@php
    // Novas classes para o estilo de "linha fina embaixo"
    $classes = ($active ?? false)
                // Classes para o link ATIVO
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary text-sm font-semibold leading-5 text-primary focus:outline-none focus:border-primary-dark transition duration-150 ease-in-out'
                // Classes para o link INATIVO
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-paragraph hover:text-headline hover:border-secondary focus:outline-none focus:text-headline focus:border-secondary transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
