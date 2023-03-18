<div>
    <div class="overflow-x-auto w-full">
        <h1 class="text-2xl font-bold">@lang('admin/title.info_available')</h1>
        <table class="table w-full">
            <thead>
                <tr>
                    <th>@lang('Avatar')</th>
                    <th>@lang('Name')</th>
                    <th>@lang('Description')</th>
                    <th>@lang('Facebook')</th>
                    <th>@lang('Gmail')</th>
                    <th>@lang('Twitter')</th>
                    <th>@lang('Linkin')</th>
                    <th>@lang('Zalo')</th>
                    <th>@lang('Github')</th>
                </tr>
            </thead>
            <tbody>
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
                    <td><a class="text-blue-700 hover:text-blue-700/50"
                            href="{{ route('admin.side-bar') }}">@lang('admin/common.watch_more_details')</a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->fb_url ?: 'javascript:void(-1)' !!}"
                            target="{{ $owner->fb_url ? '_blank' : '_self' }}">@lang('Facebook')</a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->gmail_url ?: 'javascript:void(-1)' !!}"
                            target="{{ $owner->gmail_url ? '_blank' : '_self' }}">@lang('Gmail')</a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->twitter_url ?: 'javascript:void(-1)' !!}"
                            target="{{ $owner->twitter_url ? '_blank' : '_self' }}">@lang('Twitter')</a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->linkin_url ?: 'javascript:void(-1)' !!}"
                            target="{{ $owner->linkin_url ? '_blank' : '_self' }}">@lang('Linkin')</a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->zalo_url ?: 'javascript:void(-1)' !!}"
                            target="{{ $owner->zalo_url ? '_blank' : '_self' }}">@lang('Zalo')</a></td>
                    <td><a class="text-blue-700 hover:text-blue-700/50" href="{!! $owner->github_url ?: 'javascript:void(-1)' !!}"
                            target="{{ $owner->github_url ? '_blank' : '_self' }}">@lang('Github')</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <header class="more-info-header flex justify-between items-center mt-2">
            <h1 class="text-2xl font-bold mt-3">@lang('admin/title.info_additional')</h1>
            <div class="btn-action">
                <button type="submit" form="frm-more-info"
                    class="js-btn-add btn btn-outline btn-primary btn-sm md:mt-auto">@lang('admin/common.add')</button>
                <a href="{{ route('admin.side-bar') }}"
                    class="btn btn-outline btn-sm md:mt-auto">@lang('admin/common.back')</a>
            </div>
        </header>
        @if ($errors->any())
            <div class="mt-2 alert alert-error shadow-lg text-white">
                <ul class="block">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!! Form::open([
            'route' => $infoOwner ? ['admin.owner.more-info.update', $infoOwner->id] : 'admin.owner.more-info.create',
            'method' => $infoOwner ? 'put' : 'post',
            'id' => 'frm-more-info',
        ]) !!}
        {!! Form::hidden('owner_id', $owner->id) !!}
        <div class="more-info-content">
            <div class="mt-5 md mt-0 pt-4 md:col-span-2">
                <h2 class="text-xl font-medium">@lang('admin/title.info_des_detail')</h2>
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div>
                        {{ Form::textarea('description', $infoOwner->description ?? null, ['class' => 'textarea textarea-bordered', 'id' => 'textarea__sidebar-des']) }}
                    </div>
                </div>
            </div>
            <div class="mt-5 md mt-0 pt-4 md:col-span-2">
                <h2 class="text-xl font-medium">@lang('admin/title.info_exp')</h2>
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div>
                        {{ Form::textarea('experience', $infoOwner->experience ?? null, ['class' => 'textarea textarea-bordered', 'id' => 'textarea__more-exp']) }}
                    </div>
                </div>
            </div>
            <div class="mt-5 md mt-0 pt-4 md:col-span-2">
                <h2 class="text-xl font-medium">@lang('admin/title.info_project')</h2>
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div>
                        {{ Form::textarea('project', $infoOwner->make_project ?? null, ['class' => 'textarea textarea-bordered', 'id' => 'textarea__more-pj']) }}
                    </div>
                </div>
            </div>
            <div class="mt-5 md mt-0 pt-4 md:col-span-2">
                <h2 class="text-xl font-medium">@lang('admin/title.info_goals')</h2>
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div>
                        {{ Form::textarea('career_goals', $infoOwner->career_goals ?? null, ['class' => 'textarea textarea-bordered', 'id' => 'textarea__more-career']) }}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@section('javascript')
    <script type="text/javascript" src="{{ Vite::asset('resources/assets/js/backend/admin/onwer.js') }}"></script>
    <script>
        CKEDITOR.replace('textarea__more-exp');
        CKEDITOR.replace('textarea__more-pj');
        CKEDITOR.replace('textarea__more-career');
    </script>
@endsection
