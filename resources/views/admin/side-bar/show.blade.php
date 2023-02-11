@section('title', 'Sidebar Management')
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <h2 class="font-semibold text-xl capitalize text-gray-800 leading-tight">
                {{ __('Sidebar Management') }}
            </h2>
            <a href="{{ route('admin.owner.more-info') }}"
                class="btn btn-outline btn-primary mt-5 md:mt-auto ">@lang('Add more')</a>
        </div>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('admin.side-bar', ['owner' => $owner])
        </div>
    </div>
</x-app-layout>
