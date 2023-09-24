@section('title', 'Maintain')
@section('javascript')
    <script type="text/javascript">
        const inputText = document.getElementsByClassName('input-config');
        let dataOld = new Array();
        for (let i = 0; i < inputText.length; i++) {
            dataOld[inputText[i].getAttribute('id')] = inputText[i].dataset.old;
        }
        const handleInput = () => {
            for (let id in dataOld) {
                const input = document.querySelector(`#${id}`).value;
                if (input.trim() !== dataOld[id]) {
                    document.querySelector('#btn_update_config').removeAttribute('disabled');
                    break;
                }
                document.querySelector('#btn_update_config').setAttribute('disabled', true);
            }
        }
    </script>
@endsection
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
                {{-- @csrf --}}
                {!! Form::hidden('uuid', @$configWeb->uuid) !!}
                @php
                    $maintain = '0';
                    if (empty($configWeb->maintain)) {
                        $maintain = '1';
                    } else {
                        $maintain = $configWeb->maintain == '0' ? '1' : '0';
                    }
                @endphp
                {!! Form::hidden('maintain', $maintain) !!}
                <div class="form-group">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <x-section.section-title>
                            <x-slot:title @class(['sm:justify-between'])>{{ __('Bảo trì') }}</x-slot:title>
                            <x-slot name="description">@lang('admin/common.maintain.content')</x-slot>
                        </x-section.section-title>
                        <button type="submit" class="hover:!text-white btn btn-outline btn-md btn-info mt-2">
                            @if (app()->isDownForMaintenance())
                                @lang('admin/common.maintain.turn_off')
                            @else
                                @lang('admin/common.maintain.turn_on')
                            @endif
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <hr />
            <hr />
            <div>
                {!! Form::open(['url' => route('admin.config.update', ['uuid' => @$configWeb->uuid]), 'method' => 'put']) !!}
                {{-- @csrf --}}
                {{-- @method('put') --}}
                <div class="form-group">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <x-section.section-title>
                            <x-slot:title @class(['sm:justify-between'])>{{ __('Tên website') }}</x-slot:title>
                            <x-slot name="description"></x-slot>
                        </x-section.section-title>
                        <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                            {!! Form::text('website_name', @$configWeb->website_name, [
                                'placeholder' => 'Tên website',
                                'autocomplete' => 'off',
                                'oninput' => 'handleInput()',
                                'data-old' => $configWeb->website_name ?? '',
                                'id' => 'web_name',
                                'class' =>
                                    'input-config border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-9/12',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <x-section.section-title>
                            <x-slot:title @class(['sm:justify-between'])>{{ __('Email admin') }}</x-slot:title>
                            <x-slot name="description"></x-slot>
                        </x-section.section-title>
                        <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                            {!! Form::text('email_admin', @$configWeb->email_admin, [
                                'placeholder' => 'Email',
                                'id' => 'email_admin',
                                'autocomplete' => 'off',
                                'oninput' => 'handleInput()',
                                'data-old' => $configWeb->email_admin ?? '',
                                'class' =>
                                    'input-config border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-9/12',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <x-section.section-title>
                            <x-slot:title @class(['sm:justify-between'])></x-slot:title>
                            <x-slot name="description"></x-slot>
                        </x-section.section-title>
                        <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                            {{ Form::submit(__('Update'), ['class' => 'btn btn-primary btn-outline', 'id' => 'btn_update_config', 'disabled' => true]) }}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @yield('table')
</x-app-layout>
