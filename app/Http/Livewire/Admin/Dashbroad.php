<?php

namespace App\Http\Livewire\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Livewire\Component;

class Dashbroad extends Component
{
    public function render()
    {
        $chartUsers = $this->chart();
        return view('livewire.admin.dashbroad', compact('chartUsers'));
    }

    private function chart($options = [])
    {
        //doc: https://github.com/LaravelDaily/laravel-charts
        if (empty($options)) {
            $options  = [
                'chart_title' => 'Posts by months',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Post',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'chart_type' => 'bar',
            ];
        }
        return new LaravelChart($options);
    }
}
