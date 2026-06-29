@extends('layouts.employee')

@section('title', 'My Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Good morning, {{ $employee->first_name }} 👋</h2>
        <p class="page-sub">{{ $employee->position }} — {{ $employee->department->name ?? '-' }}</p>
    </div>
</div>

<div class="stats" style="grid-template-columns:repeat(2,1fr)">
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7"><i class="ti ti-clock" style="color:#d97706"></i></div>
        <div>
            <div class="stat-label">Pending Leave</div>
            <div class="stat-val">{{ $pendingLeaves }}</div>
            <div class="stat-sub">awaiting approval</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#dcfce7"><i class="ti ti-circle-check" style="color:#16a34a"></i></div>
        <div>
            <div class="stat-label">Approved Leave</div>
            <div class="stat-val">{{ $approvedLeaves }}</div>
            <div class="stat-sub">this year</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Leave Balance {{ date('Y') }}</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Leave Type</th>
                <th style="text-align:center">Entitled</th>
                <th style="text-align:center">Used</th>
                <th style="text-align:center">Remaining</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaveBalances as $balance)
            <tr>
                <td style="font-weight:600">{{ $balance->leaveType->name }}</td>
                <td style="text-align:center">{{ $balance->entitled_days }}</td>
                <td style="text-align:center">{{ $balance->used_days }}</td>
                <td style="text-align:center">
                    <span style="color:{{ $balance->remaining_days > 0 ? '#16a34a' : '#dc2626' }};font-weight:700">
                        {{ $balance->remaining_days }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;padding:2rem;color:var(--text3)">Tiada data leave balance.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Recent Leave Requests</div>
        <a href="{{ route('employee.leave-history') }}" class="btn sm">View all</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentLeaves as $leave)
            <tr>
                <td>{{ $leave->leaveType->name }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                <td>{{ $leave->total_days }} day(s)</td>
                <td>
                    @if($leave->status == 'Approved')
                        <span class="badge badge-success">{{ $leave->status }}</span>
                    @elseif($leave->status == 'Pending')
                        <span class="badge badge-warn">{{ $leave->status }}</span>
                    @else
                        <span class="badge badge-danger">{{ $leave->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:2rem;color:var(--text3)">Tiada permohonan cuti lagi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection