<div>
    <div class="overflow-x-auto w-full">
        <h1>Thông tin đã có</h1>
        <table class="table w-full">
            <!-- head -->
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Infomation</th>
                    <th>Facebook</th>
                    <th>Gmail</th>
                    <th>Twitter</th>
                    <th>Linkin</th>
                    <th>Zalo</th>
                    <th>Github</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                <tr>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div class="avatar">
                                <div class="rounded-full w-12 h-12">
                                    <img src="{{ $owner->avatar }}" alt="Avatar {{ $owner->name }}" />
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        {{ $owner->name }}
                    </td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{{ route('admin.side-bar') }}">Xem chi
                            tiết</a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->fb_url !!}">Facebook<a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->gmail_url !!}">Gmail<a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->twitter_url !!}">Twitter<a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->linkin_url !!}">Linkin<a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->zalo_url !!}">Zalo<a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->github_url !!}">GitHub</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <h1>Thông tin bổ sung</h1>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <x-section.section-title>
                <x-slot name="title">{{ __('Description') }}</x-slot>
                <x-slot name="description">{{ __('title.description.sub') }}</x-slot>
            </x-section.section-title>
            <div class="mt-5 md mt-0 md:col-span-2">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div>
                        {{ Form::textarea('description', null, ['class' => 'textarea textarea-bordered', 'id' => 'textarea__sidebar-des']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('javascript')
    @vite('resources/js/backend/admin/onwer.js')
@endsection
