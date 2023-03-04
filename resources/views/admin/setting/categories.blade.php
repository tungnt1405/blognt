@extends('admin.setting.settings')
@section('title', 'Categories Management')

@section('table')
    @if (!$errors->isEmpty())
        <div class="mb-2 alert alert-error shadow-lg text-white w-1/3 ml-3 js-error">
            {{ __('Please enter input name category') }}</div>
    @endif
    <table class="min-w-full border-collapse block md:table">
        <thead class="block md:table-header-group">
            <tr
                class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                <th class="bg-gray-600 p-2 font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    @lang('ID')</th>
                <th class="bg-gray-600 p-2 font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    @lang('Name')</th>
                <th class="bg-gray-600 p-2 font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    @lang('Sort No')</th>
            </tr>
        </thead>
        <tbody class="block md:table-row-group">
            @foreach ($categories as $category)
                <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                    {!! Form::open([
                        'route' => ['admin.setting.category.update', $category->id],
                        'method' => 'put',
                        'class' => 'frmUpdateCategory_' . $category->id,
                    ]) !!}
                    <td class="p-2 md:border md:border-grey-500 text-left md:table-cell block">
                        <span class="block w-1/3 md:hidden font-bold">@lang('ID')</span>{{ $category->id }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">@lang('Name')</span>
                        {{ Form::text('name', $category->name, ['autocomplete' => false, 'class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 md:block w-full']) }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">@lang('Sort No')</span>
                        {{ Form::text('sort_no', $category->sort_no, ['readonly' => true, 'class' => 'border-gray-300 focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-0 rounded-md shadow-sm mt-1 md:block w-full']) }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">@lang('Edit')</button>
                        <button data-trigger="click" data-path="{{ route('admin.setting.category.delete', $category->id) }}"
                            data-method="delete" data-id="{{ $category->id }}"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">@lang('Delete')</button>
                    </td>
                    {!! Form::close() !!}
                </tr>
            @endforeach
            <tr id="frm-add-category" class="bg-gray-300 border border-grey-500 md:border-none hidden">
                {!! Form::open(['route' => 'admin.setting.category.create', 'method' => 'post']) !!}
                <td class="p-2 md:border md:border-grey-500 text-left md:table-cell hidden md:block">&nbsp;</td>
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                    <span class="inline-block w-1/3 md:hidden font-bold">@lang('Name')</span>
                    {{ Form::text('name', null, ['autocomplete' => 'off', 'class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 md:block  w-full input-category']) }}
                </td>
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                    <span class="inline-block w-1/3 md:hidden font-bold">@lang('Sort No')</span>
                    <p
                        class="border border-gray-300 focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-0 rounded-md shadow-sm mt-1 md:block w-full js-input-sortNo">
                        {{ count($categories) + 1 }}</p>
                </td>
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 font-bold text-white border border-blue-500 rounded px-2 py-1">@lang('Save')</button>
                    <button
                        class="bg-slate-100 hover:bg-slate-200 font-bold border border-slate-100 rounded px-2 py-1 btn-cancel">@lang('Cancel')</button>
                </td>
                {!! Form::close() !!}
            </tr>
        </tbody>
    </table>
    <div class="flex justify-center mt-2 hover:text-blue-700 cursor-pointer">
        <button class="btn-add-category">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/js/admin/user_data/categories.js') }}"></script>
@endsection
