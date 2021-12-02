<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Quicksand:300,500,700,800" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style type="text/css">
    body{
        font-family: 'Quicksand', sans-serif;
        font-weight: 500;
    }
  </style>

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="antialiased">
        <x-jet-banner />

        <div class="min-h-screen  bg-gradient-to-b from-gray-100  to-indigo-400">
            @livewire('navigation-menu')

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

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @livewireScripts
        <script type="text/javascript">
          @if(Session::has('success'))
          Swal.fire({
            titleText: "{{ session('success') }}",
            icon: 'success',
            position: 'center', 
            timer: 3000,
            toast: false,
            showConfirmButton: false,
          });
          @endif
          @if(Session::has('failure'))
          Swal.fire({
            titleText: "{{ session('failure') }}",
            icon: 'error',
            position: 'center', 
            timer: 3000,
            toast: false,
            showConfirmButton: false,
          });
          @endif
          @if(Session::has('info'))
          Swal.fire({
            titleText: "{{ session('info') }}",
            icon: 'info',
            position: 'center', 
            timer: 3000,
            toast: false,
            showConfirmButton: false,
          });
          @endif
          @if($errors->any())
          Swal.fire({
            titleText: "{{ implode('', $errors->all(':message')) }}",
            icon: 'error',
            position: 'center', 
            timer: 3000,
            toast: false,
            showConfirmButton: false,
          });
          @endif
        </script>
    </body>
</html>
