<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Mail\LeaveStatusMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{

    public function index()
    {
        $query = LeaveRequest::with(['employee', 'leaveType']);

        // Scope Manager hanya ke department dia sendiri
        if (auth()->user()->hasRole('manager')) {
            $managerEmployee = auth()->user()->employee;
            if ($managerEmployee) {
                $query->whereHas('employee', function($q) use ($managerEmployee) {
                    $q->where('department_id', $managerEmployee->department_id);
                });
            }
        }

        $leaves = $query->latest()->paginate(10);
        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        $query = Employee::where('status', 'Active');

        // Scope Manager hanya ke department dia sendiri
        if (auth()->user()->hasRole('manager')) {
            $managerEmployee = auth()->user()->employee;
            if ($managerEmployee) {
                $query->where('department_id', $managerEmployee->department_id);
            }
        }

        $employees = $query->get();
        $leaveTypes = LeaveType::where('is_active', true)->get();
        return view('leaves.create', compact('employees', 'leaveTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'reason'        => 'nullable|string',
        ]);

        // Sekat Manager dari apply leave bagi pekerja luar department dia
        if (auth()->user()->hasRole('manager')) {
            $managerEmployee = auth()->user()->employee;
            $targetEmployee = Employee::find($request->employee_id);
            if (!$managerEmployee || !$targetEmployee || $targetEmployee->department_id !== $managerEmployee->department_id) {
                abort(403, 'Anda tidak dibenarkan memohon cuti bagi pekerja luar department anda.');
            }
        }

        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInWeekdays($endDate) + 1;

        LeaveRequest::create([
            'employee_id'   => $request->employee_id,
            'leave_type_id' => $request->leave_type_id,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'total_days'    => $totalDays,
            'reason'        => $request->reason,
            'status'        => 'Pending',
        ]);

        return redirect()->route('leaves.index')->with('success', 'Permohonan cuti berjaya dihantar!');
    }

    public function show(LeaveRequest $leave)
    {
        $leave->load(['employee.department', 'leaveType']);
        return view('leaves.show', compact('leave'));
    }

    public function approve(LeaveRequest $leave)
    {
        // Sekat Manager dari approve leave luar department dia
        if (auth()->user()->hasRole('manager')) {
            $managerEmployee = auth()->user()->employee;
            if (!$managerEmployee || $leave->employee->department_id !== $managerEmployee->department_id) {
                abort(403, 'Anda tidak dibenarkan menguruskan cuti pekerja luar department anda.');
            }
        }

        $leave->update([
            'status'      => 'Approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $leave->employee->update(['status' => 'On leave']);

        $balance = LeaveBalance::where('employee_id', $leave->employee_id)
            ->where('leave_type_id', $leave->leave_type_id)
            ->where('year', date('Y'))
            ->first();

        if ($balance) {
            $balance->update([
                'used_days'      => $balance->used_days + $leave->total_days,
                'remaining_days' => $balance->remaining_days - $leave->total_days,
            ]);
        }

        // Hantar email notification
        if ($leave->employee?->email) {
            Mail::to($leave->employee->email)->send(new LeaveStatusMail($leave));
        }

        return redirect()->route('leaves.index')->with('success', 'Cuti telah diluluskan! Email notification dihantar.');
    }

    public function reject(Request $request, LeaveRequest $leave)
    {
        // Sekat Manager dari reject leave luar department dia
        if (auth()->user()->hasRole('manager')) {
            $managerEmployee = auth()->user()->employee;
            if (!$managerEmployee || $leave->employee->department_id !== $managerEmployee->department_id) {
                abort(403, 'Anda tidak dibenarkan menguruskan cuti pekerja luar department anda.');
            }
        }

        $leave->update([
            'status'      => 'Rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'remarks'     => $request->remarks,
        ]);

        // Hantar email notification
        if ($leave->employee?->email) {
            Mail::to($leave->employee->email)->send(new LeaveStatusMail($leave));
        }

        return redirect()->route('leaves.index')->with('success', 'Cuti telah ditolak! Email notification dihantar.');
    }

    public function destroy(LeaveRequest $leave)
    {
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Permohonan cuti berjaya dipadam!');
    }
}