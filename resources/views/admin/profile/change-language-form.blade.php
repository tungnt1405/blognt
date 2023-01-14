<x-jet-action-section>
    <x-slot name="title">{{ __('title.profile.change_language') }}</x-slot>
    <x-slot name="description">{{ __('title.profile.sub_change_language') }}</x-slot>
    <x-slot name="content">
        <div class="mt-5 space-y-6">
            <div class="flex items-center mt-5">
                <div class="form-control">
                    @foreach ($countries as $country)
                    {!! Form::open(['route' => ['admin-change-language',$country->symbol], 'method' => 'get']) !!}
                        <label class="cursor-pointer label capitalize circle js-click-btn" data-id="{{$country->id}}">
                            <span class="label-text text-lg text-left font-semibold">{{ $country->language }}</span>
                            <input type="radio" name="language" class="radio ml-4" value="{{ $country->symbol }}">
                        </label>
                        <button type="submit" class="hidden {{ 'js-btn-'.$country->id }}"></button>
                    {!! Form::close() !!}
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot>
</x-jet-action-section>
