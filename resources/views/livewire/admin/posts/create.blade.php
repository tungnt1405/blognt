<div class="bg-white w-full">
    <div class="wrapper">
        {!! Form::open(['route' => 'admin.posts.store', 'method' => 'post']) !!}
        @if ($errors->any())
            <div class="mt-5 alert alert-error shadow-lg text-white rounded-b-lg">
                <ul class="block">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Publish Post') }}</x-slot:title>
                    <x-slot name="description">{{ __('Select datetime public') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    {!! Form::text('public_date', null, [
                        'placeholder' => 'Pick datetime...',
                        'autocomplete' => 'off',
                        'id' => 'datepicker',
                        'class' =>
                            'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-9/12',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Category') }}</x-slot:title>
                    <x-slot name="description">{{ __('Select category') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    {!! Form::select('category_id', $categories, null, [
                        'placeholder' => 'Pick a category...',
                        'class' =>
                            'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-9/12',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Label') }}</x-slot:title>
                    <x-slot name="description">{{ __('Post Title') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    {!! Form::text('title', null, [
                        'id' => 'title',
                        'autocomplete' => 'off',
                        'class' =>
                            'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-9/12',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Slug') }}</x-slot:title>
                    <x-slot name="description">{{ __('Slug of post') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    {!! Form::text('slug', null, [
                        'id' => 'slug',
                        'autocomplete' => 'off',
                        'class' =>
                            'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-9/12',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Description') }}</x-slot:title>
                    <x-slot name="description">{{ __('Description of post') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    {!! Form::textarea('description', null, [
                        'id' => 'description',
                        'class' =>
                            'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Content') }}</x-slot:title>
                    <x-slot name="description">{{ __('Content of post') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    {!! Form::textarea('content', null, [
                        'id' => 'content',
                        'class' =>
                            'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Series') }}</x-slot:title>
                    <x-slot name="description">{{ __('Is the post a series of posts?') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    <div class="series-status md:py-0 py-2">
                        <input type="checkbox" id="checkbox-series" class="js-checkbox-series" name="series"
                            value="0">
                        <label for="checkbox-series">
                            <div @class(['btn-series'])></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group hidden" id="js-post-type">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Type Post') }}</x-slot:title>
                    <x-slot name="description">{{ __('Post is first or addcondition') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    <label for="post_type_1" class="cursor-pointer">
                        {!! Form::radio('post_type', 1, true, [
                            'id' => 'post_type_1',
                        ]) !!}
                        <span>First Post</span>
                    </label>

                    <label for="post_type_2" class="ml-2 cursor-pointer">
                        {!! Form::radio('post_type', 2, false, [
                            'id' => 'post_type_2',
                        ]) !!}
                        <span>Add Post For Parent</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group hidden" id="js-post-addParent">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Parent ID') }}</x-slot:title>
                    <x-slot name="description">{{ __('Post parent') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    {!! Form::text('parent_id', null, [
                        'autocomplete' => 'off',
                        'class' =>
                            'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-1/12',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Status') }}</x-slot:title>
                    <x-slot name="description">{{ __('Display or None') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    <div class="post-status md:py-0 py-2">
                        <input type="checkbox" id="checkbox-status" class="js-checkbox-status" name="status"
                            value="0">
                        <label for="checkbox-status">
                            <div @class(['btn-status'])></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="md:grid md:grid-cols-3">
            <div class="md:col-span-1"></div>
            <div class="md:col-span-2 p-5">
                <div class="flex justify-center sm:justify-end mr-4 sm:mr-auto">
                    {{ Form::submit(__('Add'), ['class' => 'btn btn-primary btn-outline']) }}
                    {{ Form::button(__('Back'), ['class' => 'btn btn-outline mx-2']) }}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@section('javascript')
    <script type="text/javascript" src="{{ Vite::asset('resources/js/backend/admin/posts.js') }}"></script>
@endsection
