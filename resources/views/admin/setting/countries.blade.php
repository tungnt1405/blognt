@extends('admin.setting.settings')
@section('title', 'Coutry Management')

@section('table')
{!! Form::open(['url' => route('admin.setting.countries.update'), 'method' => 'put']) !!}
<div class="bg-white">
    <div class="inline-block md:flex flex-row md:flex-col w-full p-3">
        <div class="md:flex hidden text-center mb-2 font-bold">
            <div class="w-1/2 mx-2">ID</div>
            <div class="w-1/2 mx-2">Name</div>
        </div>
        <div class="inline-block md:flex w-full">
            <h3 class="md:hidden">Vietnamese</h3>
            <div class="w-full md:w-1/2 mx-2">
                <label class="md:hidden">ID</label>
                <input type="text" class="w-full" name="countries[language_id][]" value="" readonly>
            </div>
            <div class="w-full md:w-1/2 mx-2">
                <label class="md:hidden">Name</label>
                <input type="text" name="countries[language_name][]" class="w-full" value="">
            </div>
        </div>
    </div>

    <div class="float-right m-4">
        {{ Form::submit(__('Save'), ['class' => 'btn btn-info btn-outline']) }}
        {{ Form::button(__('Cancel'), ['class' => 'btn btn-outline']) }}
    </div>
</div>
{!! Form::close() !!}
@endsection