@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Reports</h2>
        <p class="page-sub">Export data dalam format PDF.</p>
    </div>
</div>

<div class="stats" style="grid-template-columns:repeat(2,1fr)">
    <div class="stat-card">
        <div class="stat-icon" style="background:#eef2ff"><i class="ti ti-users" style="color:#4f46e5"></i></div>
        <div>
            <div class="stat-label">Total Employees</div>
            <div class="stat-val">{{ $totalEmployees }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7"><i class="ti ti-calendar" style="color:#d97706"></i></div>
        <div>
            <div class="stat-label">Total Leave Requests</div>
            <div class="stat-val">{{ $totalLeaves }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fee2e2"><i class="ti ti-clock" style="color:#dc2626"></i></div>
        <div>
            <div class="stat-label">Pending Leaves</div>
            <div class="stat-val">{{ $pendingLeaves }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#dcfce7"><i class="ti ti-circle-check" style="color:#16a34a"></i></div>
        <div>
            <div class="stat-label">Approved Leaves</div>
            <div class="stat-val">{{ $approvedLeaves }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Export Reports</div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div style="border:1px solid var(--border);border-radius:var(--radius);padding:1.5rem">
            <div style="font-size:16px;font-weight:700;margin-bottom:8px">
                <i class="ti ti-users" style="color:#4f46e5"></i> Employee Report
            </div>
            <p style="color:var(--text2);font-size:13px;margin-bottom:1rem">
                Senarai semua pekerja beserta maklumat department dan status.
            </p>
            <a href="{{ route('reports.employees.pdf') }}" class="btn primary">
                <i class="ti ti-file-type-pdf"></i> Export PDF
            </a>
        </div>
        <div style="border:1px solid var(--border);border-radius:var(--radius);padding:1.5rem">
            <div style="font-size:16px;font-weight:700;margin-bottom:8px">
                <i class="ti ti-calendar-off" style="color:#d97706"></i> Leave Report
            </div>
            <p style="color:var(--text2);font-size:13px;margin-bottom:1rem">
                Senarai semua permohonan cuti beserta status kelulusan.
            </p>
            <a href="{{ route('reports.leaves.pdf') }}" class="btn primary">
                <i class="ti ti-file-type-pdf"></i> Export PDF
            </a>
        </div>
    </div>
</div>
@endsection