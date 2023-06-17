<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

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
}
