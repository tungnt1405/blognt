@php
    if ($checkPost && !empty($post)) {
        $dateDiff = \Carbon\Carbon::parse($post->postsInfomation->public_date)->diffInDays(\Carbon\Carbon::now());
        if (time() > strtotime($post->postsInfomation->public_date)) {
            $dateDiff = ++$dateDiff * -1;
        }
    }
@endphp
<div class="bg-white w-full">
    <div class="wrapper">
        {!! Form::open([
            'route' => $checkPost ? ['admin.posts.update', $post->id] : 'admin.posts.store',
            'method' => $checkPost ? 'put' : 'post',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @if ($errors->any())
            <div class="mt-5 alert alert-error shadow-lg text-white rounded-b-lg">
                <ul class="block">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="post-thumb form-group">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Thumbnail Post') }}</x-slot:title>
                    <x-slot name="description">{{ __('Select thumbnail for') }}
                    </x-slot>
                </x-section.section-title>
                <div
                    class="mt-5 flex flex-col relative mt-0 md:col-span-2 px-4 sm:px-0 sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="post-thumb">
                        @if (!empty($post->thumbnail_posts))
                            <div class="thumb mb-5 pl-0">
                                <div class="w-24 sm:w-32">
                                    <img src="{{ asset('images/' . $post->thumbnail_posts) }}" loading="lazy"
                                        id="img__thumb" alt="img-show">

                                </div>
                            </div>
                        @endif
                        <div class="thumb pre-show ma-0 pa-0 hidden">
                            <div class="w-24 sm:w-32">
                                <img src id="img__show" alt="img-show">
                            </div>
                        </div>
                    </div>
                    {{ Form::file('thumbnail_posts', ['class' => 'hidden file__choose', 'accept' => 'image/*']) }}
                    {{ Form::button('Select Image', ['class' => 'w-9/12 lg:w-3/12 block btn btn-choose my-2 btn-sm md:btn-md text-white js-btn-select-img']) }}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Publish Post') }}</x-slot:title>
                    <x-slot name="description">{{ __('Select datetime public') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    {!! Form::text(
                        'public_date',
                        !empty($checkPost) ? \Carbon\Carbon::parse($post->postsInfomation->public_date) : null,
                        [
                            'placeholder' => 'Pick datetime...',
                            'autocomplete' => 'off',
                            'id' => 'datepicker',
                            'date-default' => !empty($checkPost) ? $dateDiff : 0,
                            'class' =>
                                'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-9/12',
                        ],
                    ) !!}
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
                    {!! Form::select('category_id', $categories, @$post->category_id, [
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
                    {!! Form::text('title', @$post->title, [
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
                    {!! Form::text('slug', @$post->slug, [
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
                    {!! Form::textarea('description', @$post->description, [
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
                    {!! Form::textarea('content', @$post->content, [
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
                            @if ($checkPost && $post->series == 1) checked @endif
                            value="{{ $checkPost ? $post->series : 0 }}">
                        <label for="checkbox-series">
                            <div @class(['btn-series'])></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group {{ $checkPost && $post->series == 1 ? '' : 'hidden' }}" id="js-post-type">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Type Post') }}</x-slot:title>
                    <x-slot name="description">{{ __('Post is first or addcondition') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    <label for="post_type_1" class="cursor-pointer">
                        {!! Form::radio('post_type', 0, $checkPost && $post->parent_id ? false : true, [
                            'id' => 'post_type_1',
                        ]) !!}
                        <span>{{ __('First Post') }}</span>
                    </label>

                    <label for="post_type_2" @class([
                        'ml-2 cursor-pointer',
                        'hidden' => empty($listPosts->toArray()) ? true : false,
                    ])>
                        {!! Form::radio('post_type', 1, $checkPost && $post->parent_id ? true : false, [
                            'id' => 'post_type_2',
                        ]) !!}
                        <span>{{ __('Add Post For Parent') }}</span>
                    </label>
                </div>
            </div>
        </div>
        <div @class(['form-group', 'hidden' => empty($post->parent_id)]) id="js-post-addParent">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section.section-title>
                    <x-slot:title @class(['sm:justify-between'])>{{ __('Parent ID') }}</x-slot:title>
                    <x-slot name="description">{{ __('Post parent') }}
                    </x-slot>
                </x-section.section-title>
                <div class="mt-5 flex items-center md mt-0 md:col-span-2 px-4 sm:px-0">
                    {{-- {!! Form::text('parent_id', @$post->parent_id, [
                        'autocomplete' => 'off',
                        'class' =>
                            'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-1/12',
                    ]) !!} --}}
                    {!! Form::select('parent_id', $listPosts, @$post->parent_id, [
                        'class' =>
                            'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-9/12',
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
                            @if ($checkPost && $post->postsInfomation->status == 1) checked @endif
                            value="{{ $checkPost ? $post->postsInfomation->status : 0 }}">
                        <label for="checkbox-status">
                            <div @class(['btn-status'])></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        @if ($checkPost)
            <input type="hidden" name="author_id" value="{{ $post->author_id }}">
        @endif
        <div class="md:grid md:grid-cols-3">
            <div class="md:col-span-1"></div>
            <div class="md:col-span-2 p-5">
                <div class="flex justify-center sm:justify-end mr-4 sm:mr-auto">
                    {{ Form::submit($checkPost ? __('Update') : __('Add'), ['class' => 'btn btn-primary btn-outline']) }}
                    {{ Form::button(__('Back'), ['class' => 'btn btn-outline mx-2', 'onclick' => 'location.href = `' . route('admin.posts.index') . '`']) }}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@section('javascript')
    <script type="text/javascript" src="{{ env('VITE_SOCKET_SERVER') }}/socket.io/socket.io.js"></script>
    <script type="text/javascript">
        const indexPost = false;
        const server = `{{ env('VITE_SOCKET_SERVER') }}`;
        const socketio = io(server);

        // convert echo to socket (Tham khảo)
        // const socket = io('http://your-socketio-server-url');

        // socket.on('connect', () => {
        //     const channel = `orders.${orderId}`;
        //     socket.emit('subscribe', channel);
        // });

        // socket.on('OrderShipmentStatusUpdated', (e) => {
        //     console.log(e.order);
        // });
    </script>
    @vite('resources/assets/js/backend/admin/posts.js')
@endsection
