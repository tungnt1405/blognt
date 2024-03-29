@php
    $socials = [
        // 'gmail' => 'gmail_url',
        'facebook' => 'fb_url',
        // 'twitter' => 'twitter_url',
        'linkin' => 'linkin_url',
        // 'zalo' => 'zalo_url',
        'github' => 'github_url',
    ];
    
    $route = !empty($owner) ? ['admin.side-bar.update', $owner->id] : 'admin.side-bar.new';
    $method = !empty($owner) ? 'PUT' : 'POST';
@endphp
<div>
    {!! Form::open(['route' => $route, 'method' => $method, 'enctype' => 'multipart/form-data']) !!}
    {{ Form::token() }}
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <x-section.section-title>
            <x-slot name="title">{{ __('title.owner.avatar') }}</x-slot>
            <x-slot name="description">{{ __('title.owner.sub_avatar') }}</x-slot>
        </x-section.section-title>
        <div class="mt-5 md mt-0 md:col-span-2">
            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                <div>
                    @if (!empty($owner->avatar))
                        <div class="avatar pl-2 sm:pl-0">
                            <div class="rounded-full w-24 sm:w-32">
                                <img src="{{ $owner->avatar }}" id="img__avatar" alt="img-show">
                            </div>
                        </div>
                    @endif
                    <div class="avatar pre-show pl-2 sm:pl-0 hidden">
                        <div class="rounded-full w-24 sm:w-32">
                            <img src="" id="img__show" alt="img-show">
                        </div>
                    </div>
                    {{ Form::file('avatar', ['class' => 'hidden file__choose', 'accept' => 'image/*']) }}
                    {{ Form::button('Select Image', ['class' => 'block btn btn-choose my-2 btn-sm md:btn-md text-white']) }}
                    @error('avatar')
                        <div class="mt-2 alert alert-error shadow-lg text-white">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-8">
                    {{ Form::label('name', __('Name'), ['class' => 'awesome']) }}
                    <input type="text" name="name" id="name" value="{{ @$owner->name }}"
                        class="@error('name') border-red-600 shadow-md @enderror border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    @error('name')
                        <div class="mt-2 alert alert-error shadow-lg text-white">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <x-section.section-border />
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <x-section.section-title>
            <x-slot name="title">{{ __('Description') }}</x-slot>
            <x-slot name="description">{{ __('title.description.sub') }}</x-slot>
        </x-section.section-title>
        <div class="mt-5 md mt-0 md:col-span-2">
            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                <div>
                    {{ Form::textarea('description', @$owner->introduce, ['class' => 'textarea textarea-bordered', 'id' => 'textarea__sidebar-des']) }}
                </div>
            </div>
        </div>
    </div>
    <x-section.section-border />
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <x-section.section-title>
            <x-slot name="title">{{ __('Socials') }}</x-slot>
            <x-slot name="description">{{ __('Các trang mạng xã hội sử dụng như facebook, linkin, zalo,...') }}
            </x-slot>
        </x-section.section-title>
        <div class="mt-5 md mt-0 md:col-span-2">
            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md" id="socials">
                <label class="flex justify-center hover:text-blue-700 cursor-pointer text-3xl mb-4"
                    for="checkbox_modal-show">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </label>
            </div>
        </div>
    </div>
    <div class="md:grid md:grid-cols-3">
        <div class="md:col-span-1"></div>
        <div class="md:col-span-2 mt-4">
            <div class="flex justify-center sm:justify-end mr-4 sm:mr-auto">
                {{ Form::submit(__('Cập nhật'), ['class' => 'btn btn-outline']) }}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <input type="checkbox" id="checkbox_modal-show" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle cursor-pointer">
        <div class="modal-box">
            <h2 class="font-bold text-lg">{{ __('Hãy chọn các trang mạng xã hội mày dùng đê 👻👻') }}</h2>
            @foreach ($socials as $val => $social)
                <div class="form-control mt-4">
                    <label class="cursor-pointer label justify-start select__social capitalize">
                        <input type="checkbox" class="checkbox mr-4" @checked(@$owner->$social) /> <span
                            class="label-text text-lg capitalize font-semibold">{{ $val }}</span>
                    </label>
                    <div class="hidden social">
                        <div class="mt-4">
                            {{ Form::label($val, '', ['class' => 'awesome']) }}
                            {{ Form::text($val, @$owner->$social, ['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full']) }}
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="modal-action">
                <label for="checkbox_modal-show"
                    class="btn btn-info btn-outline btn__add-field">{{ __('Thêm') }}</label>
                <label for="checkbox_modal-show" class="btn btn-ghost">{{ __('Huỷ bỏ') }}</label>
            </div>
        </div>
    </div>
</div>
@section('javascript')
    @vite('resources/assets/js/backend/admin/onwer.js')
@endsection
