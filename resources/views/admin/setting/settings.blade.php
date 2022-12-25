@section('title', 'Setting Manager')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl capitalize text-gray-800 leading-tight">
            @lang('Setting Manager')
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            {{-- @if ($errors->has('error'))
                <div class="alert alert-error shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ $errors->first('error') }}</span>
                    </div>
                </div>
            @endif --}}
            <div>
                {!! Form::open(['url' => route('admin.setting.redirect'), 'method' => 'post']) !!}
                {{ Form::select('setting', $masterTables, $view ?? null, [
                    'class' => 'select select-bordered w-xl max-w-xs',
                    'placeholder' => __('Please select a setting')
                ]) }}
                <button type="submit" class="btn btn-outline btn-md btn-info">@lang('Select')</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @yield('table')
</x-app-layout>