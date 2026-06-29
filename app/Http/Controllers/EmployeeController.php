<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
{
    $query = Employee::with('department');

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
              ->orWhere('email', 'like', '%'.$request->search.'%')
              ->orWhere('employee_no', 'like', '%'.$request->search.'%');
        });
    }

    if ($request->department) {
        $query->where('department_id', $request->department);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $employees = $query->latest()->paginate(10)->withQueryString();

    // Manager hanya nampak department dia sendiri dalam filter dropdown
    if (auth()->user()->hasRole('manager')) {
        $managerEmployee = auth()->user()->employee;
        $departments = $managerEmployee
            ? \App\Models\Department::where('id', $managerEmployee->department_id)->get()
            : collect();
    } else {
        $departments = \App\Models\Department::all();
    }

    return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string|max:80',
            'last_name'     => 'required|string|max:80',
            'email'         => 'required|email|unique:employees',
            'department_id' => 'required|exists:departments,id',
            'position'      => 'required|string|max:100',
            'joined_date'   => 'required|date',
            'status'        => 'required',
        ]);

        $employeeNo = 'EMP-' . str_pad(Employee::count() + 1, 4, '0', STR_PAD_LEFT);

        $employee = Employee::create([
            ...$request->all(),
            'employee_no' => $employeeNo,
        ]);

        AuditLog::record(
            'employee_created',
            'Added new employee: ' . $employee->full_name . ' (' . $employee->employee_no . ')',
            $employee
        );

        return redirect()->route('employees.index')->with('success', 'Pekerja berjaya ditambah!');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::where('is_active', true)->get();
        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name'    => 'required|string|max:80',
            'last_name'     => 'required|string|max:80',
            'email'         => 'required|email|unique:employees,email,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'position'      => 'required|string|max:100',
            'joined_date'   => 'required|date',
            'status'        => 'required',
        ]);

        $employee->update($request->all());

        AuditLog::record(
            'employee_updated',
            'Updated employee info: ' . $employee->full_name . ' (' . $employee->employee_no . ')',
            $employee
        );

        return redirect()->route('employees.index')->with('success', 'Maklumat pekerja berjaya dikemaskini!');
    }

    public function destroy(Employee $employee)
    {
        $employeeName = $employee->full_name;
        $employeeNo = $employee->employee_no;

        $employee->delete();

        AuditLog::record(
            'employee_deleted',
            'Deleted employee: ' . $employeeName . ' (' . $employeeNo . ')'
        );

        return redirect()->route('employees.index')->with('success', 'Pekerja berjaya dipadam!');
    }

    public function createAccount(Employee $employee)
    {
        if ($employee->user_id) {
            return redirect()->route('employees.index')->with('error', 'Pekerja ini dah ada akaun login!');
        }
        return view('employees.create-account', compact('employee'));
    }

    public function storeAccount(Request $request, Employee $employee)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:employee,manager',
        ]);

        $user = User::create([
            'name'     => $employee->full_name,
            'email'    => $employee->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        $employee->update(['user_id' => $user->id]);

        AuditLog::record(
            'account_created',
            'Created login account for ' . $employee->full_name . ' with role: ' . $request->role,
            $employee
        );

        return redirect()->route('employees.index')->with('success', 'Akaun login berjaya dicipta untuk ' . $employee->full_name . '!');
    }
}