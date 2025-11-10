<x-layouts.app.sidebar :title="$title ?? null">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
