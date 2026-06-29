@extends('layouts.app')

@section('title', 'Generate Payslip')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Generate Payslip</h2>
        <p class="page-sub">Jana slip gaji baru untuk pekerja.</p>
    </div>
    <a href="{{ route('payslips.index') }}" class="btn">
        <i class="ti ti-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <form method="POST" action="{{ route('payslips.store') }}">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0;padding-left:1rem">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-row">
            <div class="form-group">
                <label>Employee *</label>
                <select name="employee_id" required>
                    <option value="">-- Select Employee --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                            {{ $emp->full_name }} ({{ $emp->employee_no }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Month *</label>
                <select name="month" required>
                    <option value="">-- Select Month --</option>
                    @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                        <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Year *</label>
            <input type="number" name="year" value="{{ old('year', date('Y')) }}" min="2000" max="2100" required style="max-width:150px">
        </div>

        <hr style="border:none;border-top:1px solid var(--border);margin:1.5rem 0">

        <h3 style="font-size:14px;font-weight:700;margin-bottom:1rem;color:var(--text2)">Earnings</h3>

        <div class="form-row">
            <div class="form-group">
                <label>Basic Salary (RM) *</label>
                <input type="number" name="basic_salary" value="{{ old('basic_salary') }}" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label>Allowance (RM)</label>
                <input type="number" name="allowance" value="{{ old('allowance', 0) }}" step="0.01" min="0">
            </div>
        </div>

        <div class="form-group">
            <label>Overtime (RM)</label>
            <input type="number" name="overtime" value="{{ old('overtime', 0) }}" step="0.01" min="0" style="max-width:300px">
        </div>

        <h3 style="font-size:14px;font-weight:700;margin-bottom:1rem;margin-top:1.5rem;color:var(--text2)">Deductions</h3>

        <div class="form-row">
            <div class="form-group">
                <label>EPF (RM)</label>
                <input type="number" name="epf_deduction" value="{{ old('epf_deduction', 0) }}" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label>SOCSO (RM)</label>
                <input type="number" name="socso_deduction" value="{{ old('socso_deduction', 0) }}" step="0.01" min="0">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>PCB / Income Tax (RM)</label>
                <input type="number" name="pcb_deduction" value="{{ old('pcb_deduction', 0) }}" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label>Other Deduction (RM)</label>
                <input type="number" name="other_deduction" value="{{ old('other_deduction', 0) }}" step="0.01" min="0">
            </div>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:1.5rem">
            <a href="{{ route('payslips.index') }}" class="btn">Cancel</a>
            <button type="submit" class="btn primary">
                <i class="ti ti-file-invoice"></i> Generate Payslip
            </button>
        </div>
    </form>
</div>
@endsection