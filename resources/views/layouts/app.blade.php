<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if (View::hasSection('title'))
            @yield('title') {{ __('- Admin ') }}{{ config('app.name', 'Laravel') }}
        @else
            {{ __('Admin ') }}{{ config('app.name', 'Laravel') }}
        @endif
    </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">


    <!-- Styles -->
    @livewireStyles
    @yield('style')

    <!-- Scripts -->
    <script src="{{ asset('assets/js/admin/lib/jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('assets/js/admin/user_data/functions.js') }}"></script>
    @yield('header-scripts')
    @vite(['resources/assets/scss/admin/main.scss', 'resources/assets/js/backend/admin/main.js'])
</head>

<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('admin.navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    @vite('resources/assets/js/backend/admin/common.js');
    @yield('javascript')
</body>

</html>
