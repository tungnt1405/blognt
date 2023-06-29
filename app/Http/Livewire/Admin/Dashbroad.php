<?php

namespace App\Http\Livewire\Admin;

use App\Helpers\LarapexChartHelper;
use Livewire\Component;

class Dashbroad extends Component
{
    public function render()
    {
        $chart = $this->chart();
        return view('livewire.admin.dashbroad', compact('chart'));
    }

    private function chart()
    {
        $data = [
            'San Francisco' => [6, 9, 3, 4, 10, 8, 9],
            'Boston' => [7, 3, 8, 2, 6, 4]
        ];
        return LarapexChartHelper::barChart(
            __('admin/title.dashboard.chart.post_tile'),
            __('admin/title.dashboard.common.month'),
            $data,
            config('constants.DAILY_MONTH')
        );
    }

    private function getPost()
    {
    }
}
