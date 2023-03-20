<?php

namespace Database\Seeders;

use App\Models\Master\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'english' => 'en',
            'vietnamese' => 'vi',
        ];
        $sort_no = 0;
        $inserts = [];

        foreach ($data as $l => $s) {
            if (empty($this->isLanguageExist(['language' => $l, 'symbol' => $s]))) {
                $sort_no++;

                $inserts[] = [
                    'language' => $l,
                    'symbol' => $s,
                    'sort_no' => $sort_no,
                ];
            }
        }

        if (!empty($inserts)) {
            DB::table('mtb_countries')->insert($inserts);
        }
    }

    private function isLanguageExist($columns)
    {
        return DB::table('mtb_countries')
            ->select(['*'])
            ->where('language', $columns['language'])
            ->where('symbol', $columns['symbol'])
            ->first();
    }
}
