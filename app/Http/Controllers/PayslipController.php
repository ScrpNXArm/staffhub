<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payslip;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    public function index(Request $request)
    {
        $query = Payslip::with('employee.department');

        // Scope Manager hanya ke department dia sendiri
        if (auth()->user()->hasRole('manager')) {
            $managerEmployee = auth()->user()->employee;
            if ($managerEmployee) {
                $query->whereHas('employee', function($q) use ($managerEmployee) {
                    $q->where('department_id', $managerEmployee->department_id);
                });
            }
        }

        if ($request->month) {
            $query->where('month', $request->month);
        }

        if ($request->year) {
            $query->where('year', $request->year);
        }

        if ($request->search) {
            $query->whereHas('employee', function($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%')
                  ->orWhere('employee_no', 'like', '%'.$request->search.'%');
            });
        }

        $payslips = $query->latest()->paginate(10)->withQueryString();

        return view('payslips.index', compact('payslips'));
    }

    public function create()
    {
        $query = Employee::where('status', '!=', 'Resigned');

        if (auth()->user()->hasRole('manager')) {
            $managerEmployee = auth()->user()->employee;
            if ($managerEmployee) {
                $query->where('department_id', $managerEmployee->department_id);
            }
        }

        $employees = $query->get();

        return view('payslips.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'      => 'required|exists:employees,id',
            'month'             => 'required|string',
            'year'              => 'required|integer|min:2000|max:2100',
            'basic_salary'      => 'required|numeric|min:0',
            'allowance'         => 'nullable|numeric|min:0',
            'overtime'          => 'nullable|numeric|min:0',
            'epf_deduction'     => 'nullable|numeric|min:0',
            'socso_deduction'   => 'nullable|numeric|min:0',
            'pcb_deduction'     => 'nullable|numeric|min:0',
            'other_deduction'  => 'nullable|numeric|min:0',
        ], [
            'employee_id.required' => 'Sila pilih pekerja.',
        ]);

        // Sekat Manager dari generate payslip pekerja luar department dia
        if (auth()->user()->hasRole('manager')) {
            $managerEmployee = auth()->user()->employee;
            $targetEmployee = Employee::find($request->employee_id);
            if (!$managerEmployee || !$targetEmployee || $targetEmployee->department_id !== $managerEmployee->department_id) {
                abort(403, 'Anda tidak dibenarkan menjana payslip bagi pekerja luar department anda.');
            }
        }

        $basicSalary = $request->basic_salary;
        $allowance = $request->allowance ?? 0;
        $overtime = $request->overtime ?? 0;
        $epf = $request->epf_deduction ?? 0;
        $socso = $request->socso_deduction ?? 0;
        $pcb = $request->pcb_deduction ?? 0;
        $otherDeduction = $request->other_deduction ?? 0;

        $grossSalary = $basicSalary + $allowance + $overtime;
        $totalDeduction = $epf + $socso + $pcb + $otherDeduction;
        $netSalary = $grossSalary - $totalDeduction;

        $payslip = Payslip::create([
            'employee_id'      => $request->employee_id,
            'month'             => $request->month,
            'year'              => $request->year,
            'basic_salary'      => $basicSalary,
            'allowance'         => $allowance,
            'overtime'          => $overtime,
            'epf_deduction'     => $epf,
            'socso_deduction'   => $socso,
            'pcb_deduction'     => $pcb,
            'other_deduction'  => $otherDeduction,
            'net_salary'        => $netSalary,
            'generated_by'      => auth()->id(),
        ]);

        AuditLog::record(
            'payslip_generated',
            'Generated payslip for ' . $payslip->employee->full_name . ' (' . $payslip->month . ' ' . $payslip->year . ')',
            $payslip
        );

        return redirect()->route('payslips.index')->with('success', 'Payslip berjaya dijana!');
    }

    public function show(Payslip $payslip)
    {
        $payslip->load('employee.department');
        return view('payslips.show', compact('payslip'));
    }

    public function destroy(Payslip $payslip)
    {
        $employeeName = $payslip->employee->full_name;
        $period = $payslip->month . ' ' . $payslip->year;

        $payslip->delete();

        AuditLog::record(
            'payslip_deleted',
            'Deleted payslip for ' . $employeeName . ' (' . $period . ')'
        );

        return redirect()->route('payslips.index')->with('success', 'Payslip berjaya dipadam!');
    }
}