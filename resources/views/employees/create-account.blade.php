@extends('layouts.app')

@section('title', 'Create Login Account')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Create Login Account</h2>
        <p class="page-sub">{{ $employee->full_name }} — {{ $employee->employee_no }}</p>
    </div>
    <a href="{{ route('employees.index') }}" class="btn">
        <i class="ti ti-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div style="display:flex;align-items:center;gap:14px;padding-bottom:1.5rem;margin-bottom:1.5rem;border-bottom:1px solid var(--border)">
        <div class="emp-avatar" style="width:52px;height:52px;font-size:18px;background:#4f46e5">
            {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
        </div>
        <div>
            <div style="font-weight:700;font-size:16px">{{ $employee->full_name }}</div>
            <div style="color:var(--text2);font-size:13px">{{ $employee->position }} — {{ $employee->department->name ?? '-' }}</div>
            <div style="color:var(--text3);font-size:12px">{{ $employee->email }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('employees.store-account', $employee) }}">
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
            <label>Email (Login)</label>
            <input type="text" value="{{ $employee->email }}" disabled style="background:#f9fafb;color:var(--text2)">
            <small style="color:var(--text3);font-size:11px">Email pekerja akan digunakan sebagai username login.</small>
        </div>

        <div class="form-group">
            <label>Role *</label>
            <select name="role" required>
                <option value="">-- Select Role --</option>
                <option value="employee">Employee — akses profile & leave sendiri sahaja</option>
                <option value="manager">Manager — boleh approve leave pekerja lain</option>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" required placeholder="Minimum 8 characters">
            </div>
            <div class="form-group">
                <label>Confirm Password *</label>
                <input type="password" name="password_confirmation" required placeholder="Repeat password">
            </div>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:1rem">
            <a href="{{ route('employees.index') }}" class="btn">Cancel</a>
            <button type="submit" class="btn primary">
                <i class="ti ti-user-plus"></i> Create Account
            </button>
        </div>
    </form>
</div>
@endsection