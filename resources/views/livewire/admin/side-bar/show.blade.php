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
                <div class="avatar px-6 sm:pl-4 hidden">
                    <div class="rounded-full w-24 sm:w-32">
                        <img src="" id="img__show" alt="img-show">
                    </div>
                </div>
                {{ Form::file('avatar', ['class' => 'hidden file__choose', 'accept' => 'image/*']) }}
                {{ Form::button('Select Image', ['class' => 'block btn btn-choose my-2 ml-3 btn-sm md:btn-md text-white']) }}
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
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
            <span><i class="view-grid-plus"></i></span>
            <div>
                {{ Form::label('facebook', '', ['class' => 'awesome']) }}
                {{ Form::text('facebook', null, ['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full']) }}
            </div>
            <div class="mt-4">
                {{ Form::label('twitter', '', ['class' => 'awesome']) }}
                {{ Form::text('twitter', null, ['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full']) }}
            </div>
            <div class="mt-4">
                {{ Form::label('linkin', '', ['class' => 'awesome']) }}
                {{ Form::text('linkin', null, ['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full']) }}
            </div>
            <div class="mt-4">
                {{ Form::label('zalo', '', ['class' => 'awesome']) }}
                {{ Form::text('zalo', null, ['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full']) }}
            </div>
            <div class="mt-4">
                {{ Form::label('github', '', ['class' => 'awesome']) }}
                {{ Form::text('github', null, ['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full']) }}
            </div>
            <div class="mt-4">
                {{ Form::label('gmail', '', ['class' => 'awesome']) }}
                {{ Form::text('gmail', null, ['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full']) }}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@section('script')
    <script>
        $(function() {
            CKEDITOR.replace('textarea__sidebar-des', {
                filebrowserUploadUrl: "{{ route('admin.dashboard') }}",
                filebrowserUploadMethod: 'form'
            });
            const preview_image = function() {
                let file_upload = $(this).val();
                if (file_upload != '') {
                    const url_demo = URL.createObjectURL(event.target.files[0]);
                    $('.avatar').removeClass('hidden');
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
        });
    </script>
@endsection
