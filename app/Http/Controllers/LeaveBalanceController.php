<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveBalanceController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');
        $query = Employee::with(['leaveBalances' => function($q) use ($year) {
            $q->where('year', $year)->with('leaveType');
        }]);

        // Scope Manager hanya ke department dia sendiri
        if (auth()->user()->hasRole('manager')) {
            $managerEmployee = auth()->user()->employee;
            if ($managerEmployee) {
                $query->where('department_id', $managerEmployee->department_id);
            }
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%')
                  ->orWhere('employee_no', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->department) {
            $query->where('department_id', $request->department);
        }

        $employees = $query->paginate(10)->withQueryString();

        // Manager hanya nampak department dia sendiri dalam filter dropdown
        if (auth()->user()->hasRole('manager')) {
            $managerEmployee = auth()->user()->employee;
            $departments = $managerEmployee
                ? \App\Models\Department::where('id', $managerEmployee->department_id)->get()
                : collect();
        } else {
            $departments = \App\Models\Department::all();
        }

        $leaveTypes = LeaveType::where('is_active', true)->get();

        return view('leave-balances.index', compact('employees', 'departments', 'leaveTypes', 'year'));
    }
}