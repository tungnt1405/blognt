<div class="wrapper bg-white w-full">
    <div class="bg-slate-200 posts-header p-5">
        <div class="posts-header-search mb-3">
            {!! Form::text('search', null, [
                'placeholder' => 'Enter keywords search posts as label post, slug ',
                'class' =>
                    'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-9/12',
            ]) !!}

            <div class="posts-category-search my-3 hidden">
                <h2 class="font-bold text-lg">{{ __('Select Category') }}</h2>
                @foreach ($categories as $category)
                    <label class="mr-4">
                        <input type="checkbox" name="category[]" class="checkbox checkbox-sm" value="{{ $category->id }}" />
                        <span> {{ $category->name }} </span>
                    </label>
                @endforeach
            </div>
            <div class="posts-status-search hidden">
                <h2 class="font-bold text-lg"> {{ __('Select Status') }} </h2>
                <label class="mr-4">
                    <input type="radio" name="status" class="radio radio-sm" value="1" checked />
                    <span> {{ __('Display') }} </span>
                </label>
                <label class="mr-4">
                    <input type="radio" name="status" class="radio radio-sm" value="0" />
                    <span> {{ __('None') }} </span>
                </label>
            </div>
        </div>
        <label class="search-options cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </label>
        <div class="btn-search mt-4">
            <button class="btn btn-info btn-active text-white btn-sm">Search</button>
            <label for="show-modal-delete" class="btn btn-error btn-active text-white btn-sm hidden js-delete-post">
                {{ __('Delete') }}
            </label>
            <label for="show-modal-soft-delete"
                class="btn btn-error btn-active text-white btn-sm hidden js-delete-post">
                {{ __('Remove trash') }}
            </label>
        </div>
    </div>
    <div class="posts-body">
        <div class="overflow-x-auto w-full">
            <table class="table-normal w-full">
                <!-- head -->
                <thead class="text-left">
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" class="checkbox js-checkbox-all" />
                            </label>
                        </th>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Label') }}</th>
                        <th>{{ __('Slug') }}</th>
                        <th>{{ __('Date Publish') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Description') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" class="checkbox js-checkbox-post" name="post_ids[]"
                                        value="{{ $post->id }}" />
                                </label>
                            </td>
                            <td>{{ $post->id }}</td>
                            <td><a href=""
                                    class="text-blue-700 hover:text-blue-500 hover:underline hover:text-lg">{{ $post->title }}</a>
                            </td>
                            <td>{{ $post->slug }}</td>
                            <td>
                                <p class="cursor-pointer" title="{{ $post->postsInfomation->public_date }}">
                                    {{ \Carbon\Carbon::parse($post->postsInfomation->public_date)->format('d-m-Y') }}
                                <p>
                            </td>
                            <td>
                                {!! Form::select(
                                    'post-status',
                                    [
                                        0 => 'None',
                                        1 => 'Display',
                                    ],
                                    $post->postsInfomation->status,
                                    [
                                        'class' =>
                                            'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block',
                                        'data-path' => route('admin.posts.update.status', ['id' => $post->id]),
                                        'data-method' => 'put',
                                        'data-trigger' => 'change',
                                    ],
                                ) !!}
                            </td>
                            <td>{{ $post->category->name }}</td>
                            <td>{!! $post->description !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="posts-footer"></div>
    @include('livewire.admin.posts.show001')
</div>
@section('javascript')
    @vite('resources/js/backend/admin/posts.js')
@endsection
