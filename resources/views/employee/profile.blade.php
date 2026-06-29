@extends('layouts.employee')

@section('title', 'My Profile')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">My Profile</h2>
        <p class="page-sub">Maklumat peribadi anda.</p>
    </div>
</div>

<div class="card">
    <div style="display:flex;align-items:center;gap:20px;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border)">
        <div class="emp-avatar" style="width:64px;height:64px;font-size:22px;background:#4f46e5">
            {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
        </div>
        <div>
            <div style="font-size:20px;font-weight:700">{{ $employee->full_name }}</div>
            <div style="color:var(--text2)">{{ $employee->position }}</div>
            <div style="font-size:12px;color:var(--text3);margin-top:4px">{{ $employee->employee_no }}</div>
        </div>
        <div style="margin-left:auto">
            @if($employee->status == 'Active')
                <span class="badge badge-success" style="font-size:14px;padding:6px 16px">{{ $employee->status }}</span>
            @elseif($employee->status == 'On leave')
                <span class="badge badge-warn" style="font-size:14px;padding:6px 16px">{{ $employee->status }}</span>
            @else
                <span class="badge badge-danger" style="font-size:14px;padding:6px 16px">{{ $employee->status }}</span>
            @endif
        </div>
    </div>

    <div class="form-row">
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Email</div>
            <div>{{ $employee->email }}</div>
        </div>
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Phone</div>
            <div>{{ $employee->phone ?? '-' }}</div>
        </div>
    </div>

    <div class="form-row" style="margin-top:1rem">
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">IC No</div>
            <div>{{ $employee->ic_no ?? '-' }}</div>
        </div>
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Gender</div>
            <div>{{ $employee->gender ?? '-' }}</div>
        </div>
    </div>

    <div class="form-row" style="margin-top:1rem">
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Department</div>
            <div>{{ $employee->department->name ?? '-' }}</div>
        </div>
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Employment Type</div>
            <div>{{ $employee->employment_type }}</div>
        </div>
    </div>

    <div class="form-row" style="margin-top:1rem">
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Joined Date</div>
            <div>{{ \Carbon\Carbon::parse($employee->joined_date)->format('d M Y') }}</div>
        </div>
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Date of Birth</div>
            <div>{{ $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('d M Y') : '-' }}</div>
        </div>
    </div>

    <div style="margin-top:1rem">
        <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Address</div>
        <div>{{ $employee->address ?? '-' }}</div>
    </div>
</div>
@endsection