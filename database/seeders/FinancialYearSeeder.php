<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Current year
        $currentYear = Carbon::now()->year;

        // Previous year
        $years = [];
        $years[] = $currentYear - 1;

        // Next 4 years
        for ($i = 0; $i < 4; $i++) {
            $years[] = $currentYear + $i;
        }

        foreach ($years as $year) {
            $start_date = Carbon::create($year, 4, 1); // FY start on 1st April
            $end_date = Carbon::create($year + 1, 3, 31); // FY end on 31st March
            $name = $year . '-' . ($year + 1);

            DB::table('financial_years')->updateOrInsert(
                ['name' => $name],
                [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'is_active' => $year == $currentYear ? true : false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
