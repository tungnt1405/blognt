<div class="md:grid md:grid-cols-3 md:gap-6">
    <x-section-title>
        <x-slot name="title">{{ __('Avatar') }}</x-slot>
    </x-section-title>
    <div class="mt-5 md mt-0 md:col-span-2">
        {!! Form::open(['route' => 'admin.side-bar.new', 'enctype' => 'multipart/form-data']) !!}
        {{ Form::token() }}
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
            {{ Form::file('avatar', ['class' => 'hidden file__choose']) }}
            {{ Form::button('Select Image', ['class' => 'btn btn-choose my-2 ml-3 btn-sm md:btn-md text-white']) }}
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script>
    $('.btn-choose').on('click', function() {
        $('.file__choose').click()
    });
</script>
