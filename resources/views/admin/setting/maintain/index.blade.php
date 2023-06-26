@section('title', 'Maintain')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl capitalize text-gray-800 leading-tight">
            @lang('Maintain')
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div>
                {!! Form::open(['url' => route('admin.toggle.maintain'), 'method' => 'post']) !!}
                @csrf
                <h1>@lang('admin/common.maintain.content')</h1>
                <button type="submit" class="hover:!text-white btn btn-outline btn-md btn-info mt-2">
                    @if (app()->isDownForMaintenance())
                        @lang('admin/common.maintain.turn_off')
                    @else
                        @lang('admin/common.maintain.turn_on')
                    @endif
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @yield('table')
</x-app-layout>
