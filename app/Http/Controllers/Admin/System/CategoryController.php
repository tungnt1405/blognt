<?php

namespace App\Http\Controllers\Admin\System;

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
            $this->toastrSuccess('Insert Failed', 'Error');
        } else {
            $this->toastrSuccess('Insert Success', 'Success');
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
            $this->toastrError('Update failed', 'Error');
        } else {
            $this->toastrSuccess('Updated Success', 'Success');
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
            $this->toastrError('Delete failed', 'Error');
        } else {
            $this->toastrSuccess('Delete Success', 'Success');
        }

        return redirect()->route('admin.setting.show', ['view' => 'categories']);
    }
}
