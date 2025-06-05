<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        // Show the dashboard with sidebar
        return view('employee.dashboard');
    }

    public function clients($department)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }
        $employee = $user->employee;
        if (!$employee) {
            return redirect()->route('employee.dashboard')->with('error', 'You are not assigned as an employee.');
        }
        $clients = $employee->clients()->where('department', $department)->get();
        $tasks = $clients->flatMap(function ($client) {
            return $client->tasks;
        });
        return view('employee.clients', compact('clients', 'department', 'tasks'));
    }
}
