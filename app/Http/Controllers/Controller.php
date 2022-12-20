<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * @param string $message
     * @param string $title
     * @param array $options
     * 
     * @return Toastr
     */
    public function toastrSuccess($message, $title = '', array $option = array())
    {
        return toastr()->success($message, $title, $option);
    }

    /**
     * @param string $message
     * @param string $title
     * @param array $options
     * 
     * @return Toastr
     */
    public function toastrInfo($message, $title = '', array $option = array())
    {
        return toastr()->info($message, $title, $option);
    }

    /**
     * @param string $message
     * @param string $title
     * @param array $options
     * 
     * @return Toastr
     */
    public function toastrWarning($message, $title = '', array $option = array())
    {
        return toastr()->warning($message, $title, $option);
    }

    /**
     * @param string $message
     * @param string $title
     * @param array $options
     * 
     * @return Toastr
     */
    public function toastrError($message, $title = '', array $option = array())
    {
        return toastr()->error($message, $title, $option);
    }
}
