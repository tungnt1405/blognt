<?php

namespace App\Http\Livewire\Admin;

use ArielMejiaDev\LarapexCharts\LarapexChart;
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
        // doc: https://larapex-charts.netlify.app/
        $chart = new LarapexChart();
        return $chart->barChart()
            ->setTitle('San Francisco vs Boston.')
            ->setSubtitle('Wins during season 2021.')
            ->addData('San Francisco', [6, 9, 3, 4, 10, 8, 9])
            ->addData('Boston', [7, 3, 8, 2, 6, 4])
            ->setXAxis([
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ]);
    }
}
