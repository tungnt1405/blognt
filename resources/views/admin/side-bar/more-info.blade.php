@section('title', 'Owner information')
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <h2 class="font-semibold text-xl capitalize text-gray-800 leading-tight">
                {{ __('Sidebar Management') }}
            </h2>
        </div>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('admin.side-bar.more-info', ['owner' => $allOwner, 'infoOwner' => $infoOwner])
        </div>
    </div>
</x-app-layout>
