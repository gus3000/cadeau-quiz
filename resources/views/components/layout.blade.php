<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadeau Quiz</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased text-gray-700 bg-gray-100">
{{ $slot }}

<footer>
    @stack('scripts')
</footer>
</body>
</html>
