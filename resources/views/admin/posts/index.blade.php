@section('title', 'Posts Management')
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <h2 class="font-semibold text-xl capitalize text-gray-800 leading-tight">
                {{ __('Posts Management') }}
                <br><a href="{{ route('admin.clear-cache-posts') }}"><small>{{ __('Clear cache') }}</small></a>
            </h2>
            <a href="{{ route('admin.posts.create') }}"
                class="btn btn-outline btn-primary mt-5 md:mt-auto ">@lang('Add new')</a>
        </div>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            {{-- @livewire('admin.posts.show', [
                'categories' => $categories,
                'isTrash' => $isTrash,
                'posts' => $posts
            ]) --}}
            @include('livewire.admin.posts.show', [
                'categories' => $categories,
                'isTrash' => $isTrash,
                'posts' => $posts,
                'totalPosts' => $totalPosts,
                'totalPostsSoftDelete' => $totalPostsSoftDelete,
                'searchTerm' => $searchTerm,
                'searchCategory' => $searchCategory,
                'searchStatus' => $searchStatus,
                'checkSearch' => $checkSearch,
            ])
        </div>
    </div>
</x-app-layout>
