<?php

namespace App\Http\Controllers\FinancialYear;

use App\Http\Controllers\Controller;
use App\Models\FinancialYear\FinancialYearModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialYearController extends Controller
{
    public function financialYearsView()
    {
        $financialYear = FinancialYearModel::get();
        return view('admin.pages.financial-year.list', compact('financialYear'));
    }

    public function updateFinancialYear(Request $request)
    {
        $request->validate([
            'name' => 'required|string|exists:financial_years,name',
        ], [
            'name.required' => 'The financial year field is required.',
        ]);

        $selectedYear = $request->input('name');

        DB::transaction(function () use ($selectedYear) {
            FinancialYearModel::query()->update(['is_active' => 0]);
            FinancialYearModel::where('name', $selectedYear)
                ->update(['is_active' => 1]);
        });

        return redirect()->back()->with('success', 'Financial year updated successfully.');
    }

    public function setFinancialYear($id, Request $request)
    {
        $year = FinancialYearModel::find($id);

        if ($year) {
            $request->session()->put('financial_year', [
                'id'         => $year->id,
                'name'       => $year->name,
                'start_date' => $year->start_date,
                'end_date'   => $year->end_date,
            ]);

            // return redirect()->back()->with('success', 'Financial Year Changed to ' . $year->name);
            return redirect()->back();
        }

        return redirect()->back()->with('error', 'Financial Year Not Found');
    }
}
