<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Requests\Setting\AddCountriesRequest;
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
    public function addCountries(AddCountriesRequest $request)
    {
        $data = $request->all();

        if(!$request->isMethod('put')) abort(405);

        if(empty($data['countries']['language_name'])){
            return redirect()->route('admin.setting.show',['view'=>'countries']);
        }
        
        $mergeIdFromVal = array();
        
        if(empty($data['countries']['language_id'][0]) && isset($data['countries']['language_name'][0])){
            dd($data);
            foreach($data['countries'] as $country){
                foreach($country['language_id'] as $id){
                    array_push($mergeIdFromVal, $id);
                }
            }
        }
        dd($data['countries']['language_name'][0]);

        return redirect()->route('');
    }
}
