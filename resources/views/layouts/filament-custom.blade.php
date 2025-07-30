<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filament</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- ถ้าใช้ Vite --}}
    @livewireStyles
</head>
<body>
    {{ $slot }}

    @livewireScripts
</body>
</html>
