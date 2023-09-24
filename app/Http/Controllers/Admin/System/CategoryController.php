<?php

namespace App\Http\Controllers\Admin\System;

use App\Helpers\ToastrHelper;
use App\Http\Requests\admin\Setting\StoreCategoriesRequest;
use App\Http\Requests\admin\Setting\UpdateCategoriesRequest;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends SettingsController
{

    /**
     * @var \App\Services\Admin\CategoryService $categoryService
     */
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(StoreCategoriesRequest $request)
    {
        $data = $request->all();
        $all_categories = $this->categoryService->all()->toArray();
        $attributes = [];
        $attributes['name'] = $data['name'];
        $attributes['sort_no'] = count($all_categories) + 1;

        $insert = $this->categoryService->create($attributes);

        if (!$insert) {
            ToastrHelper::toastrSuccess('Insert Failed', 'Error');
        } else {
            ToastrHelper::toastrSuccess('Insert Success', 'Success');
        }

        return redirect()->route('admin.setting.show', ['view' => 'categories']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriesRequest $request, $id = null)
    {
        $data = $request->all();

        $attributes = [];
        $attributes['name'] = $data['name'];
        $attributes['sort_no'] = $data['sort_no'];
        $update = $this->categoryService->update($id, $attributes);
        if (!$update) {
            ToastrHelper::toastrError('Update failed', 'Error');
        } else {
            ToastrHelper::toastrSuccess('Updated Success', 'Success');
        }

        return redirect()->route('admin.setting.show', ['view' => 'categories']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int|null  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id = null)
    {
        $delete = $this->categoryService->delete($id);
        if (!$delete) {
            ToastrHelper::toastrError('Delete failed', 'Error');
        } else {
            ToastrHelper::toastrSuccess('Delete Success', 'Success');
        }

        return redirect()->route('admin.setting.show', ['view' => 'categories']);
    }
}
