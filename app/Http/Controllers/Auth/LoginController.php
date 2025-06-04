<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect employee-related roles to employee dashboard
            $employeeRoles = ['Manager', 'Recruiter', 'Accountant', 'Agent', 'SalesRep'];
            if (Auth::user()->roles()->whereIn('name', $employeeRoles)->exists()) {
                return redirect('/employee/dashboard');
            }

            // Default redirect
            return redirect('/');
        }
        return back()->with('error', 'Invalid credentials.')->withInput();
    }
}
