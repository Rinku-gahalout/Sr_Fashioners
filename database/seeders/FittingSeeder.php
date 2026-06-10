<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fitting;
use Illuminate\Support\Str;

class FittingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fittings = [
            'Narrow Fit',
            'Comfort Fit',
            'Relax Fit',
            'Straight Fit',
            'Boot Cut',
        ];

        foreach ($fittings as $fitting) {

            Fitting::updateOrCreate(
                ['slug' => Str::slug($fitting)],
                [
                    'name' => $fitting,
                    'status' => 1,
                ]
            );
        }
    }
}
