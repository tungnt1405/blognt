@section('title', 'Posts Management')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/lib/jquery-ui.css') }}">
@endsection
@section('header-scripts')
    <script src="{{ asset('assets/js/admin/lib/jquery-ui.js') }}"></script>
@endsection
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <h2 class="font-semibold text-xl capitalize text-gray-800 leading-tight">
                {{ __('Posts Management') }}
                <br><small>{{ __('Add New') }}</small>
            </h2>
            {{-- <a href="{{ route('admin.owner.more-info') }}"
                class="btn btn-outline btn-primary mt-5 md:mt-auto ">@lang('More other')</a> --}}
            @if ($checkPost)
                <div class="post-btn">
                    <label for="show-modal-delete" class="btn btn-error btn-active text-white btn-sm">
                        {{ __('Delete') }}
                    </label>
                    @if ($isTrash)
                        <label for="show-modal-soft-delete" class="btn btn-info btn-active text-white btn-sm">
                            {{ __('Restore') }}
                        </label>
                    @else
                        <label for="show-modal-soft-delete" class="btn btn-error btn-active text-white btn-sm">
                            {{ __('Remove trash') }}
                        </label>
                    @endif
                    <input type="checkbox" class="hidden js-checkbox-post" name="post_ids[]" checked
                        value="{{ $post->id }}" />
                </div>
            @endif
        </div>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('admin.posts.create', [
                'categories' => $categories,
                'post' => $post ?? [],
                'checkPost' => $checkPost,
                'listPosts' => $listPosts,
            ])
        </div>
    </div>
    @include('livewire.admin.posts.show001')
</x-app-layout>
