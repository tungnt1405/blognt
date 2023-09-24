<?php

namespace App\Http\Controllers\Admin\System;

use App\Helpers\ToastrHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Config;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Mockery\Expectation;
use Yoeunes\Toastr\Facades\Toastr;

class SettingsController extends AdminController
{
    /**
     * @var array $masterData
     */
    private $__masterData;

    public function __construct()
    {
        $this->__masterData = $this->getAllMasterTable();

        //tham khảo các cách share all data cho view
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

    public function configWebsite()
    {
        $configWeb = Config::all()->first();
        return view('admin.setting.config.index', compact('configWeb'));
    }

    public function updateConfig(Request $request, $uuid = null)
    {
        if (empty($uuid)) {
            $create = Config::create([
                'website_name' => $request->input('website_name'),
                'email_admin' => $request->input('email_admin')
            ]);
            if ($create) {
                ToastrHelper::toastrSuccess('Updated successfully', 'Success');
            } else {
                ToastrHelper::toastrError('Updated Failed', 'Error');
            }
        } else {
            $update = Config::find($uuid)->update([
                'website_name' => $request->input('website_name'),
                'email_admin' => $request->input('email_admin')
            ]);
            if ($update) {
                ToastrHelper::toastrSuccess('Updated successfully', 'Success');
            } else {
                ToastrHelper::toastrError('Updated Failed', 'Error');
            }
        }

        return back();
    }

    public function toggleMaintain(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            try {
                Log::info('maintain');
                if (empty($request->input('uuid'))) {
                    Config::create(['maintain' => $request->input('maintain')]);
                } else {
                    $config = Config::find($request->input('uuid'));
                    if (empty($config)) {
                        Log::error('Not found uuid', [$request->input('uuid')]);
                        abort(500);
                    }
                    $config->update(['maintain' => $request->input('maintain')]);
                }

                if (app()->isDownForMaintenance()) {
                    Artisan::call('up');
                    ToastrHelper::toastrSuccess('admin/common.maintain.up');
                } else {
                    Artisan::call('down');
                    ToastrHelper::toastrSuccess(__('admin/common.maintain.down'));
                }

                return redirect()->back();
            } catch (Exception $e) {
                Log::error('Update config website:' . $e->getMessage(), [$request->input('uuid')]);
                if (app()->environment('local', 'development', 'dev', 'test')) {
                    throw new Exception('Update config website failed!');
                }
                abort(500);
            }
        }
    }
}
