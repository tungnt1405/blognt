<?php

namespace App\Http\Livewire\Admin;

use App\Helpers\LarapexChartHelper;
use Livewire\Component;

class Dashbroad extends Component
{
    public function render()
    {
        $perOfYear = ['posts' => $this->sortPerPost($this->getPerPostByYear())];
        $chart = $this->chart($perOfYear);
        return view('livewire.admin.dashbroad', compact('chart'));
    }

    private function chart($data)
    {
        // $data = [
        //     'posts' => [6, 9, 3, 4, 10, 8, '1' => 9],
        //     // 'Boston' => [7, 3, 8, 2, 6, 4]
        // ];

        return LarapexChartHelper::barChart(
            __('admin/title.dashboard.chart.post_tile'),
            __('admin/title.dashboard.chart.post'),
            $data,
            config('constants.DAILY_MONTH')
        );
    }

    private function getPerPostByYear()
    {
        $year = \Carbon\Carbon::now()->year;
        return \App\Services\Admin\PostsService::singleton()->getPerPostByYear($year)->toArray();
    }

    private function sortPerPost($data, $type = 0) // 0: years, 1: months, 2: weeks
    {
        $newData = [];

        switch ($type) {
            case 1:
                return [];
            case 2:
                return [];
            case 0:
            default:
                for ($i = 0; $i < 12; $i++) {
                    array_push($newData, 0);
                }

                foreach ($data as $item) {
                    $newData[(int) --$item['month']] = $item['per_of_month'];
                }

                return $newData;
        }
    }
}
