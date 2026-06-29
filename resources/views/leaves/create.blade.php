@extends('layouts.app')

@section('title', 'Apply Leave')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Apply Leave</h2>
        <p class="page-sub">Submit a new leave request.</p>
    </div>
    <a href="{{ route('leaves.index') }}" class="btn">
        <i class="ti ti-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <form method="POST" action="{{ route('leaves.store') }}">
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
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->full_name }} ({{ $employee->employee_no }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Leave Type *</label>
                <select name="leave_type_id" required>
                    <option value="">-- Select Leave Type --</option>
                    @foreach($leaveTypes as $type)
                        <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }} ({{ $type->days_allowed }} days)
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Start Date *</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" required>
            </div>
            <div class="form-group">
                <label>End Date *</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Reason</label>
            <textarea name="reason" rows="3" placeholder="Optional reason...">{{ old('reason') }}</textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:1rem">
            <a href="{{ route('leaves.index') }}" class="btn">Cancel</a>
            <button type="submit" class="btn primary">
                <i class="ti ti-send"></i> Submit Request
            </button>
        </div>
    </form>
</div>
@endsection