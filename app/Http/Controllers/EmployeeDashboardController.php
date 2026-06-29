<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function dashboard()
    {
        $employee = auth()->user()->employee;

        if (!$employee) {
            return redirect()->route('dashboard')->with('error', 'Profile pekerja tidak dijumpai!');
        }

        $leaveBalances = LeaveBalance::where('employee_id', $employee->id)
            ->where('year', date('Y'))
            ->with('leaveType')
            ->get();

        $recentLeaves = LeaveRequest::where('employee_id', $employee->id)
            ->with('leaveType')
            ->latest()
            ->take(5)
            ->get();

        $pendingLeaves = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'Pending')
            ->count();

        $approvedLeaves = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'Approved')
            ->count();

        return view('employee.dashboard', compact(
            'employee',
            'leaveBalances',
            'recentLeaves',
            'pendingLeaves',
            'approvedLeaves'
        ));
    }

    public function applyLeave()
    {
        $employee = auth()->user()->employee;
        $leaveTypes = LeaveType::where('is_active', true)->get();
        return view('employee.apply-leave', compact('employee', 'leaveTypes'));
    }

    public function storeLeave(Request $request)
    {
        $employee = auth()->user()->employee;

        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'reason'        => 'nullable|string',
        ]);

        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInWeekdays($endDate) + 1;

        LeaveRequest::create([
            'employee_id'   => $employee->id,
            'leave_type_id' => $request->leave_type_id,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'total_days'    => $totalDays,
            'reason'        => $request->reason,
            'status'        => 'Pending',
        ]);

        return redirect()->route('employee.dashboard')->with('success', 'Permohonan cuti berjaya dihantar!');
    }

    public function profile()
    {
        $employee = auth()->user()->employee;
        return view('employee.profile', compact('employee'));
    }

    public function leaveHistory()
    {
        $employee = auth()->user()->employee;
        $leaves = LeaveRequest::where('employee_id', $employee->id)
            ->with('leaveType')
            ->latest()
            ->paginate(10);

        return view('employee.leave-history', compact('leaves', 'employee'));
    }
}