<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function loginView(){
        return view('admin.pages.auth.login');
    }
    public function loginAttempt(Request $request){
        // dd($request->all());
        $request->validate([
            'user_id' => 'required',
            'password' => 'required',
        ]);
        $credentials = [
            'user_id'   => $request->user_id,
            'password'  => $request->password,
        ];

        $userId = $request->user_id;
        $password = $request->password;
        $remember = $request->has('remember');
        
        if(Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();
            $user = Auth::user();

            switch ($user->role) {
                case 'Super Admin':
                    return redirect()->route('admin.dashboard')->with('success','Login Success');
                case 'employee':
                    // $redirect = route('employee.dashboard');
                    break;

                case 'customer':
                    // $redirect = route('customer.dashboard');
                    break;

                default:
                    Auth::logout();
                    return redirect()->back()->with('error','Unauthorized Access');
            }            
        }else{
            return redirect()->back()->with('error','Invalid user ID or password');
        }

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->back()->with('success','Logout Success');
    }
}
