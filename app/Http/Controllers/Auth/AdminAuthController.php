<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CompanyDetails\CompanyDetailModel;
use App\Models\FinancialYear\FinancialYearModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function loginView()
    {
        return view('admin.pages.auth.login');
    }

    public function loginAttempt(Request $request)
    {
        $request->validate([
            'user_id'  => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'user_id'  => $request->user_id,
            'password' => $request->password,
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $currentFinancialYear = FinancialYearModel::where('is_active', 1)->first();

            if ($currentFinancialYear) {

                $request->session()->put('financial_year', [
                    'id'         => $currentFinancialYear->id,
                    'name'       => $currentFinancialYear->name,
                    'start_date' => $currentFinancialYear->start_date,
                    'end_date'   => $currentFinancialYear->end_date,
                ]);
            }

            switch ($user->role) {
                case 'Super Admin':
                    $companyExists = CompanyDetailModel::count();
                    if ($companyExists > 0) {
                        return redirect()->route('admin.dashboard')->with('success', 'Login Successful');
                    } else {
                        return redirect()->route('admin.company_details.companyDetailsForm');
                    }

                case 'employee':
                    // return redirect()->route('employee.dashboard')->with('success', 'Login Successful');
                    break;

                case 'customer':
                    // return redirect()->route('customer.dashboard')->with('success', 'Login Successful');
                    break;

                default:
                    Auth::logout();
                    return redirect()->back()->with('error', 'Unauthorized Access');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid User ID or Password');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->back()->with('success', 'Logout Success');
    }
}
