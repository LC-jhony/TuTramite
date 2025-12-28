<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body class="antialiased bg-stone-50 dark:bgstone-900 transition-colors">
    <x-navbar>
        <x-slot name='logo'>
            <x-logo brandName='Tu Tramite' :href="route('document-procedure-form')" />
        </x-slot>
        <x-nav-link :href="route('document-procedure-form')" :active="request()->routeIs('document-procedure-form')">
            Tramite
        </x-nav-link>
        {{-- <x-nav-link :href="route('consultation.form')" :active="request()->routeIs('consultation.form')">
            Consulta Tramite
        </x-nav-link> --}}

        <x-slot name='login'>
            <x-nav-link :href="route('filament.admin.auth.login')" :active="request()->routeIs('filament.admin.auth.login')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

                Iniciar Sesión
            </x-nav-link>
        </x-slot>
    </x-navbar>

    {{ $slot }}

    @livewire('notifications') {{-- Only required if you wish to send flash notifications --}}

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
