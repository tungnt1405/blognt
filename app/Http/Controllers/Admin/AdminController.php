<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ToastrHelper;
use App\Utils\CommonUtil;
use App\Utils\RedisUtil;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * get all master data tables
     * 
     * @return DB
     */
    public function getAllMasterTable()
    {
        $allTable = DB::select("SHOW TABLES");
        $masterTable = array();
        foreach ($allTable as $table) {
            if (strpos($table->Tables_in_blognt, 'mtb_') !== false) {
                $masterTable[str_ireplace('mtb_', '', $table->Tables_in_blognt)] = $table->Tables_in_blognt;
            }
        }

        return $masterTable;
    }

    public function clearCachePosts()
    {
        if (RedisUtil::deleteKey('posts')) {
            ToastrHelper::toastrSuccess('Clear cache success!', 'Success');
        } else {
            ToastrHelper::toastrWarning('Not found cache posts.', 'Warning');
        }
        return redirect()->back();
    }

    public function cache()
    {
        return view('admin.cache.index');
    }

    public function cacheOptimize()
    {
        try {
            Log::info('Blognt: Cache optimize');
            ToastrHelper::toastrSuccess('Cached successfully', 'Success');
            CommonUtil::newCache();
            return redirect()->route('admin.cache.index');
        } catch (\Exception $ex) {
            CommonUtil::displayError($ex->getMessage(), get_class());
        }
    }

    public function cacheOptimizeClear()
    {
        try {
            Log::info('Blognt: Clear optimze cache');
            ToastrHelper::toastrSuccess('Clear cached successfully', 'Success');
            CommonUtil::newCache();
            return redirect()->route('admin.cache.index');
        } catch (\Exception $ex) {
            CommonUtil::displayError($ex->getMessage(), get_class());
        }
    }
}
