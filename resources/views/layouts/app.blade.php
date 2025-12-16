<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
        darkMode: localStorage.getItem('theme') === 'dark'
      }" x-init="
        $watch('darkMode', val => {
          localStorage.setItem('theme', val ? 'dark' : 'light');
          document.documentElement.setAttribute('data-bs-theme', val ? 'dark' : 'light');
        });
        document.documentElement.setAttribute(
          'data-bs-theme',
          darkMode ? 'dark' : 'light'
        );
      ">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-body">
    <div class="d-flex flex-column min-vh-100">
        <div class="border-bottom">
            @if(Auth::check() && Auth::user()->role === 'admin')
            @include('layouts.partials.admin_navbar')
            @else
            @include('layouts.partials.employee_navbar')
            @endif
        </div>

        {{-- Page Heading --}}
        @hasSection('header')
        <header class="bg-body border-bottom mb-4">
            <div class="container py-4">
                <div class="h4 mb-0 fw-bold text-body">
                    @yield('header')
                </div>
            </div>
        </header>
        @endif

        {{-- Page Content --}}
        <main>
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>

</html>