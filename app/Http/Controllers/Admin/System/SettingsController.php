<?php

namespace App\Http\Controllers\Admin\System;

use App\Helpers\ToastrHelper;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class SettingsController extends AdminController
{
    /**
     * @var array $masterData
     */
    private $__masterData;

    public function __construct()
    {
        $this->__masterData = $this->getAllMasterTable();

        //tham khảo các cách share all dât cho view
        //https://chungnguyen.xyz/posts/truyen-du-lieu-ra-view-trong-laravel
        view()->share('masterTables', $this->__masterData);
    }

    /**
     * settings view
     */
    public function index()
    {
        return view('admin.setting.settings');
    }

    /**
     * settings view display
     * 
     * @param string $view
     */
    public function show($view = null)
    {
        $display = 'admin.setting.' . $view;
        if (view()->exists($display)) {
            return view($display)->with(['view' => $view]);
        }

        abort(404);
    }

    /**
     * redirect to url selected
     * 
     * @param Request $request
     */
    public function redirectToSelected(Request $request)
    {
        $data = $request->all();
        if (empty($data['setting'])) {
            // return back()->withError('error', trans('validation.admin.setting.error'));
            // return back()->withErrors(['error' => trans('validation.admin.setting.error')]);
            ToastrHelper::toastrError(trans('validation.admin.setting.error'));
            return back();
        }

        return redirect()->route('admin.setting.show', ['view' => $data['setting']]);
    }
}
