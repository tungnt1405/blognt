<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Utils\CommonUtil;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Log;

class LarapexChartHelper
{
    const TYPE_ERROR_NORMAL = 1;
    const TYPE_ERROR_CHART = 2;

    private static function createLarapex()
    {
        try {
            // doc: https://larapex-charts.netlify.app/
            // tham khảo: https://apexcharts.com/
            return new LarapexChart();
        } catch (\Exception $ex) {
            Log::error('Construct apexchart fail: ', $ex->getMessage());
            self::displayError($ex->getMessage(), get_class());
            abort(500);
        }
    }

    public static function barChart($title = '', $subTitle = '', $data, $xAxis)
    {
        self::displayError($data, $xAxis, self::TYPE_ERROR_CHART);

        Log::info('Create bar chart:', $data);
        $barChart = self::createLarapex()->barChart()
            ->setTitle($title)
            ->setSubtitle($subTitle)
            ->setXAxis($xAxis);

        foreach ($data as $key => $item) {
            $barChart->addData($key, $item);
        }
        Log::info('End create bar chart');
        return $barChart;
    }

    private static function displayError($message, $classname, $type = self::TYPE_ERROR_NORMAL) // type: 1-normal 2-chart
    {
        if ($type === self::TYPE_ERROR_NORMAL) {
            return CommonUtil::displayError($message, $classname);
        }

        // show log create chart
        if (empty($message)) { // check exist data to create chart
            return CommonUtil::displayError(__('validation.helper.larapex.data_empty'), get_class());
        }

        if (empty($classname)) { // check exist xAxis to create chart
            return CommonUtil::displayError(__('validation.helper.larapex.xAxis_empty'), get_class());
        }
    }
}
