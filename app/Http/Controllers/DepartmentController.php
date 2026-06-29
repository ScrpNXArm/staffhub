<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->latest()->paginate(10);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:departments',
        ]);

        $department = Department::create([
            'name'      => $request->name,
            'code'      => strtoupper($request->code),
            'is_active' => $request->has('is_active'),
        ]);

        AuditLog::record(
            'department_created',
            'Added new department: ' . $department->name . ' (' . $department->code . ')',
            $department
        );

        return redirect()->route('departments.index')->with('success', 'Department berjaya ditambah!');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:departments,code,' . $department->id,
        ]);

        $department->update([
            'name'      => $request->name,
            'code'      => strtoupper($request->code),
            'is_active' => $request->has('is_active'),
        ]);

        AuditLog::record(
            'department_updated',
            'Updated department: ' . $department->name . ' (' . $department->code . ')',
            $department
        );

        return redirect()->route('departments.index')->with('success', 'Department berjaya dikemaskini!');
    }

    public function destroy(Department $department)
    {
        if ($department->employees()->count() > 0) {
            return redirect()->route('departments.index')->with('error', 'Tidak boleh padam — department ini masih ada pekerja!');
        }

        $departmentName = $department->name;
        $departmentCode = $department->code;

        $department->delete();

        AuditLog::record(
            'department_deleted',
            'Deleted department: ' . $departmentName . ' (' . $departmentCode . ')'
        );

        return redirect()->route('departments.index')->with('success', 'Department berjaya dipadam!');
    }
}