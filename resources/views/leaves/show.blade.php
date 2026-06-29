@extends('layouts.app')

@section('title', 'Leave Details')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Leave Details</h2>
        <p class="page-sub">{{ $leave->employee->full_name ?? 'Unknown' }}</p>
    </div>
    <a href="{{ route('leaves.index') }}" class="btn">
        <i class="ti ti-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div style="display:flex;align-items:center;gap:20px;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border)">
        <div class="emp-avatar" style="width:64px;height:64px;font-size:22px;background:#4f46e5">
            {{ $leave->employee ? strtoupper(substr($leave->employee->first_name,0,1).substr($leave->employee->last_name,0,1)) : 'N/A' }}
        </div>
        <div>
            <div style="font-size:20px;font-weight:700">{{ $leave->employee?->full_name }}</div>
            <div style="color:var(--text2)">{{ $leave->employee?->position }}</div>
            <div style="font-size:12px;color:var(--text3);margin-top:4px">{{ $leave->employee?->department?->name ?? '-' }}</div>
        </div>
        <div style="margin-left:auto">
            @if($leave->status == 'Approved')
                <span class="badge badge-success" style="font-size:14px;padding:6px 16px">{{ $leave->status }}</span>
            @elseif($leave->status == 'Pending')
                <span class="badge badge-warn" style="font-size:14px;padding:6px 16px">{{ $leave->status }}</span>
            @else
                <span class="badge badge-danger" style="font-size:14px;padding:6px 16px">{{ $leave->status }}</span>
            @endif
        </div>
    </div>

    <div class="form-row">
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Leave Type</div>
            <div style="font-weight:600">{{ $leave->leaveType?->name ?? '-' }}</div>
        </div>
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Total Days</div>
            <div style="font-weight:600">{{ $leave->total_days }} day(s)</div>
        </div>
    </div>

    <div class="form-row" style="margin-top:1rem">
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Start Date</div>
            <div>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</div>
        </div>
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">End Date</div>
            <div>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</div>
        </div>
    </div>

    <div style="margin-top:1rem">
        <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Reason</div>
        <div>{{ $leave->reason ?? '-' }}</div>
    </div>

    @if($leave->remarks)
    <div style="margin-top:1rem">
        <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Remarks</div>
        <div>{{ $leave->remarks }}</div>
    </div>
    @endif

    @if($leave->status == 'Pending')
    <div style="display:flex;gap:10px;margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--border)">
        <form method="POST" action="{{ route('leaves.approve', $leave) }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn primary">
                <i class="ti ti-check"></i> Approve
            </button>
        </form>
        <form method="POST" action="{{ route('leaves.reject', $leave) }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn danger" onclick="return confirm('Tolak permohonan ini?')">
                <i class="ti ti-x"></i> Reject
            </button>
        </form>
    </div>
    @endif
</div>
@endsection