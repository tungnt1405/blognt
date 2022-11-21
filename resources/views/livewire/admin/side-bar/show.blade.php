<?php
$socials = [
    1 => 'facebook',
    2 => 'twitter',
    3 => 'linkin',
    4 => 'zalo',
    5 => 'github',
    6 => 'gmail',
];
?>
{!! Form::open(['route' => 'admin.side-bar.new', 'enctype' => 'multipart/form-data']) !!}
{{ Form::token() }}
<div class="md:grid md:grid-cols-3 md:gap-6">
    <x-section.section-title>
        <x-slot name="title">{{ __('Avatar') }}</x-slot>
        <x-slot name="description">{{ __('Hiển thị ảnh trên sidebar của website') }}</x-slot>
    </x-section.section-title>
    <div class="mt-5 md mt-0 md:col-span-2">
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
            <div>
                <div class="avatar pl-2 sm:pl-0 hidden">
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
                {{ Form::label('name', __('Tên của mày'), ['class' => 'awesome']) }}
                <input type="text" name="name" id="name"
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
        <x-slot name="description">{{ __('Mô tả ngắn gọn về bản thân như mục tiêu, sở thích, ...') }}</x-slot>
    </x-section.section-title>
    <div class="mt-5 md mt-0 md:col-span-2">
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
            <div>
                {{ Form::textarea('description', null, ['class' => 'textarea textarea-bordered', 'id' => 'textarea__sidebar-des']) }}
            </div>
        </div>
    </div>
</div>
<x-section.section-border />
<div class="md:grid md:grid-cols-3 md:gap-6">
    <x-section.section-title>
        <x-slot name="title">{{ __('Socials') }}</x-slot>
        <x-slot name="description">{{ __('Các trang mạng xã hội sử dụng như facebook, linkin, zalo,...') }}</x-slot>
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
                <label class="cursor-pointer label justify-start select__social">
                    <input type="checkbox" class="checkbox mr-4">
                    <span class="label-text text-lg capitalize font-semibold">{{ $social }}</span>
                </label>
                <div class="hidden social">
                    <div class="mt-4">
                        {{ Form::label($social, '', ['class' => 'awesome']) }}
                        {{ Form::text($social, null, ['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full']) }}
                    </div>
                </div>
            </div>
        @endforeach
        <div class="modal-action">
            <label for="checkbox_modal-show" class="btn btn-info btn-outline btn__add-field">Thêm</label>
            <label for="checkbox_modal-show" class="btn btn-ghost">Huỷ bỏ</label>
        </div>
    </div>
</div>
@section('script')
    <script>
        $(function() {
            CKEDITOR.replace('textarea__sidebar-des', {
                filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
                filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserUploadMethod: 'form',
            });
            const preview_image = function() {
                let file_upload = $(this).val();
                if (file_upload != '') {
                    const url_demo = URL.createObjectURL(event.target.files[0]);
                    $('.avatar').removeClass('hidden');
                    const url_old = $('.avatar #img__show').attr('src');
                    if (url_old != undefined || url_old.trim() != '') {
                        URL.revokeObjectURL($('.avatar #img__show').attr('src'));
                    }
                    $('.avatar #img__show').attr('src', url_demo);
                } else {
                    $('.avatar').attr('src', '');
                    $('.avatar #img__show').addClass('hidden');
                }

            };
            $('.btn-choose').on('click', function() {
                $('.file__choose').click();

                $('.file__choose').on('change blur', preview_image)
            });

            $('.btn__add-field').on('click', function() {
                $('#socials').find('div').remove();
                $('label input:checkbox').each(function(index, element) {
                    if ($(element).is(':checked')) {
                        $('#socials').append($(element).closest('div').find('.social div').clone());
                    }
                })
            })

            $(window).on('load', function() {
                $('.btn-choose').click();
            })
        });
    </script>
@endsection
