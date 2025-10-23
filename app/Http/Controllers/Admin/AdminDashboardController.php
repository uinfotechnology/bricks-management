<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FinancialYearModel;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $selectedFinancialYear = session('financial_year.name');

        // Total Accounts
        $totalAccounts = DB::table('account')
            ->where('financial_year', $selectedFinancialYear)
            ->count();

        // Total Labours
        $totalLabours = DB::table('labours')
            ->where('financial_year', $selectedFinancialYear)
            ->count();

        // Total Vehicles
        $totalVehicles = DB::table('vehicles')
            ->where('financial_year', $selectedFinancialYear)
            ->count();

        // Total Purchases
        $totalPurchases = DB::table('purchases')
            ->where('financial_year', $selectedFinancialYear)
            ->count();

        // Total Bricks Sold (sum of quantity)
        $totalBricksSold = DB::table('bricks_sales')
            ->where('financial_year', $selectedFinancialYear)
            ->sum('quantity');

        // Total Bricks Produced (sum of bricks_quantity)
        $totalBricksProduced = DB::table('labour_work_details')
            ->where('financial_year', $selectedFinancialYear)
            ->sum('bricks_quantity');

        return view('admin.index', compact(
            'totalAccounts',
            'totalLabours',
            'totalVehicles',
            'totalPurchases',
            'totalBricksSold',
            'totalBricksProduced',
            'selectedFinancialYear'
        ));
    }
}
