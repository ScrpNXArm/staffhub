@extends('layouts.employee')

@section('title', 'Apply Leave')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Apply Leave</h2>
        <p class="page-sub">Hantar permohonan cuti baru.</p>
    </div>
    <a href="{{ route('employee.dashboard') }}" class="btn">
        <i class="ti ti-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <form method="POST" action="{{ route('employee.store-leave') }}">
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

        <div class="form-group">
            <label>Leave Type *</label>
            <select name="leave_type_id" required>
                <option value="">-- Select Leave Type --</option>
                @foreach($leaveTypes as $type)
                    <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
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
            <textarea name="reason" rows="4" placeholder="Sebab permohonan cuti (optional)">{{ old('reason') }}</textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:1rem">
            <a href="{{ route('employee.dashboard') }}" class="btn">Cancel</a>
            <button type="submit" class="btn primary">
                <i class="ti ti-send"></i> Submit Application
            </button>
        </div>
    </form>
</div>
@endsection