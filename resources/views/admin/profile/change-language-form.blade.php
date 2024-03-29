<x-jet-action-section>
    <x-slot name="title">{{ __('title.profile.change_language') }}</x-slot>
    <x-slot name="description">{{ __('title.profile.sub_change_language') }}</x-slot>
    <x-slot name="content">
        <div class="mt-5 space-y-6">
            <div class="flex items-center mt-5">
                @if (count($countries) > 0)
                    <div class="form-control">
                        @foreach ($countries as $country)
                            {!! Form::open(['route' => ['admin.change-language', $country->symbol], 'method' => 'get']) !!}
                            <label class="cursor-pointer label capitalize circle js-click-btn"
                                data-id="{{ $country->id }}">
                                <span class="label-text text-lg text-left font-semibold">{{ $country->language }}</span>
                                <input type="radio" name="language" class="radio ml-4"
                                    @if (app()->getLocale() === $country->symbol) checked="checked" @endif
                                    value="{{ $country->symbol }}">
                            </label>
                            <button type="submit" class="hidden {{ 'js-btn-' . $country->id }}"></button>
                            {!! Form::close() !!}
                        @endforeach
                    </div>
                @else
                    <div class="flex">
                        <p class="mr-2">{{ __('admin/common.profile.language_empty') }}</p>
                        <a href="{{ route('admin.setting.show', ['view' => 'countries']) }}"
                            class="text-lg font-bold uppercase leading-snug text-blue-900 hover:text-blue-900/70">{{ __('Here') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
</x-jet-action-section>
