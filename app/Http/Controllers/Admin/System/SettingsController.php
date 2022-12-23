<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * @var array $masterData
     */
    private $__masterData;

    public function __construct()
    {
        $this->__masterData = $this->getAllMasterTable();
    }

    /**
     * settings view
     * 
     */
    public function index()
    {
        //tham khảo
        //https://chungnguyen.xyz/posts/truyen-du-lieu-ra-view-trong-laravel
       return view('admin.setting.settings', ['masterTables' => $this->__masterData]);
    }

    public function countries()
    {
        return view('admin.setting.countries',['masterTables' => $this->__masterData]);
    }

    /**
     * redirect to url selected
     * 
     * @param Request $request
     */
    public function redirectToSelected(Request $request)
    {
        $data = $request->all();
        if(empty($data['setting'])){
            // return back()->withError('error', trans('validation.admin.setting.error'));
            // return back()->withErrors(['error' => trans('validation.admin.setting.error')]);
            $this->toastrError(trans('validation.admin.setting.error'));
            return back();
        }

        $page = 'admin.setting.' . $data['setting'];
        return redirect()->route($page);
    }
}
