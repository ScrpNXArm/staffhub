<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalLeaves = LeaveRequest::count();
        $pendingLeaves = LeaveRequest::where('status', 'Pending')->count();
        $approvedLeaves = LeaveRequest::where('status', 'Approved')->count();

        return view('reports.index', compact(
            'totalEmployees',
            'totalLeaves',
            'pendingLeaves',
            'approvedLeaves'
        ));
    }

    public function exportEmployeesPdf()
    {
        $employees = Employee::with('department')->get();
        $pdf = Pdf::loadView('reports.employees-pdf', compact('employees'));
        return $pdf->download('employees-report.pdf');
    }

    public function exportLeavesPdf()
    {
        $leaves = LeaveRequest::with(['employee', 'leaveType'])->get();
        $pdf = Pdf::loadView('reports.leaves-pdf', compact('leaves'));
        return $pdf->download('leaves-report.pdf');
    }
}