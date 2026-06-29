<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $employeeQuery = Employee::query();
        $departmentQuery = Department::query();
        $isManager = auth()->user()->hasRole('manager');
        $managerEmployee = $isManager ? auth()->user()->employee : null;

        // Scope Manager hanya ke department dia sendiri
        if ($isManager && $managerEmployee) {
            $employeeQuery->where('department_id', $managerEmployee->department_id);
            $departmentQuery->where('id', $managerEmployee->department_id);
        }

        $totalEmployees = $employeeQuery->count();
        $activeEmployees = (clone $employeeQuery)->where('status', 'Active')->count();
        $onLeave = (clone $employeeQuery)->where('status', 'On leave')->count();
        $totalDepartments = $departmentQuery->count();
        $recentEmployees = (clone $employeeQuery)->with('department')->latest()->take(5)->get();

        if ($isManager && $managerEmployee) {
            $departmentStats = Department::where('id', $managerEmployee->department_id)
                ->withCount('employees')
                ->get();
        } else {
            $departmentStats = Department::withCount('employees')->get();
        }

        // Data untuk Bar Chart: Headcount by Department
        $chartDepartmentLabels = $departmentStats->pluck('name');
        $chartDepartmentData = $departmentStats->pluck('employees_count');

        // Data untuk Doughnut Chart: Leave Status Breakdown
        $leaveQuery = LeaveRequest::query();
        if ($isManager && $managerEmployee) {
            $leaveQuery->whereHas('employee', function($q) use ($managerEmployee) {
                $q->where('department_id', $managerEmployee->department_id);
            });
        }

        $chartLeaveData = [
            'Pending'  => (clone $leaveQuery)->where('status', 'Pending')->count(),
            'Approved' => (clone $leaveQuery)->where('status', 'Approved')->count(),
            'Rejected' => (clone $leaveQuery)->where('status', 'Rejected')->count(),
        ];

        return view('dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'onLeave',
            'totalDepartments',
            'recentEmployees',
            'departmentStats',
            'chartDepartmentLabels',
            'chartDepartmentData',
            'chartLeaveData'
        ));
    }
}