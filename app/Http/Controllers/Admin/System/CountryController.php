<?php

namespace App\Http\Controllers\Admin\System;

use App\Helpers\ToastrHelper;
use App\Http\Requests\admin\Setting\AddCountriesRequest;
use App\Http\Requests\admin\Setting\UpdateCountriesRequest;
use App\Services\Admin\CountryService;

class CountryController extends SettingsController
{
    /**
     * @var \App\Services\Admin\CountryService
     */
    protected $_countryService;

    public function __construct(CountryService $countryService)
    {
        $this->_countryService = $countryService;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(AddCountriesRequest $request)
    {
        $data = $request->request->all();
        $all_countries = $this->_countryService->all()->toArray();
        $new_data = array_merge($data, array('sort_no' => count($all_countries) + 1));

        $insert = $this->_countryService->insert($new_data);

        if (!$insert) {
            ToastrHelper::toastrSuccess('Insert Failed', 'Error');
        } else {
            ToastrHelper::toastrSuccess('Insert Success', 'Success');
        }

        return redirect()->route('admin.setting.show', ['view' => 'countries']);
    }


    public function update(UpdateCountriesRequest $rq, $id)
    {

        $data = $rq->all();
        $update = $this->_countryService->update($id, $data);
        if (!$update) {
            ToastrHelper::toastrError('Update failed', 'Error');
        } else {
            ToastrHelper::toastrSuccess('Updated Success', 'Success');
        }

        return redirect()->route('admin.setting.show', ['view' => 'countries']);
    }

    public function delete($id)
    {
        $delete = $this->_countryService->delete($id);
        if (!$delete) {
            ToastrHelper::toastrError('Delete failed', 'Error');
        } else {
            ToastrHelper::toastrSuccess('Delete Success', 'Success');
        }

        return redirect()->route('admin.setting.show', ['view' => 'countries']);
    }
}
