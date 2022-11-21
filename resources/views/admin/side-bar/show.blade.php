@section('title', 'Sidebar Management')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl capitalize text-gray-800 leading-tight">
            {{ __('sidebar management') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('admin.side-bar')
        </div>
    </div>
</x-app-layout>
