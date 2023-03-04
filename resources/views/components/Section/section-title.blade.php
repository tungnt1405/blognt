@props(['title'])
<div
    {{ $title->attributes->class(['md:col-span-1', 'flex', 'sm:flex-column', 'justify-between', 'sm:justify-center', 'sm:items-center']) }}>
    <div class="px-4 sm:px-0">
        <h3 class="text-lg font-bold text-gray-900">{{ $title }}</h3>

        <p class="mt-1 text-sm text-gray-600">
            {{ $description ?? '' }}
        </p>
    </div>

    <div class="px-4 sm:px-0">
        {{ $aside ?? '' }}
    </div>
</div>
