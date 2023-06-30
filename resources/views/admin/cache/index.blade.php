@section('title', 'Cache Management')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl capitalize text-gray-800 leading-tight">
            @lang('Cache Management')
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div>
                <h1>@lang('admin/common.cache.index')</h1>
                <a href="{{ route('admin.cache.optimize.index') }}"
                    class="hover:!text-white btn btn-outline btn-md btn-info mt-2">
                    @lang('Cache')
                </a>
            </div>

            <div class="mt-2">
                <h1>@lang('admin/common.cache.clear')
                </h1>
                <a href="{{ route('admin.cache.optimize.clear') }}"
                    class="hover:!text-white btn btn-outline btn-md btn-info mt-2">
                    @lang('Clear cache')
                </a>
            </div>
        </div>
    </div>
    @yield('table')
</x-app-layout>
