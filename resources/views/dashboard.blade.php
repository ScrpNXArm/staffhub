@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Good morning, {{ auth()->user()->name }} 👋</h2>
        <p class="page-sub">Here's what's happening with your team today.</p>
    </div>
</div>

<div class="stats">
    <div class="stat-card">
        <div class="stat-icon" style="background:#eef2ff"><i class="ti ti-users" style="color:#4f46e5"></i></div>
        <div>
            <div class="stat-label">Total Employees</div>
            <div class="stat-val">{{ $totalEmployees }}</div>
            <div class="stat-sub">across all departments</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#dcfce7"><i class="ti ti-circle-check" style="color:#16a34a"></i></div>
        <div>
            <div class="stat-label">Active</div>
            <div class="stat-val">{{ $activeEmployees }}</div>
            <div class="stat-sub">currently working</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7"><i class="ti ti-beach" style="color:#d97706"></i></div>
        <div>
            <div class="stat-label">On Leave</div>
            <div class="stat-val">{{ $onLeave }}</div>
            <div class="stat-sub">this month</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e0f2fe"><i class="ti ti-building" style="color:#0891b2"></i></div>
        <div>
            <div class="stat-label">Departments</div>
            <div class="stat-val">{{ $totalDepartments }}</div>
            <div class="stat-sub">active units</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1rem;margin-bottom:1rem">
    <div class="card" style="margin-bottom:0">
        <div class="card-header">
            <div class="card-title">Headcount by Department</div>
        </div>
        <div style="height:280px">
            <canvas id="departmentChart"></canvas>
        </div>
    </div>
    <div class="card" style="margin-bottom:0">
        <div class="card-header">
            <div class="card-title">Leave Status</div>
        </div>
        <div style="height:280px">
            <canvas id="leaveChart"></canvas>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Recent Employees</div>
        <a href="{{ route('employees.index') }}" class="btn sm">View all</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Status</th>
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentEmployees as $employee)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <div class="emp-avatar" style="background:#4f46e5">
                            {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600">{{ $employee->full_name }}</div>
                            <div style="font-size:11px;color:var(--text3)">{{ $employee->email }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $employee->department->name ?? '-' }}</td>
                <td>{{ $employee->position }}</td>
                <td>
                    @if($employee->status == 'Active')
                        <span class="badge badge-success">{{ $employee->status }}</span>
                    @elseif($employee->status == 'On leave')
                        <span class="badge badge-warn">{{ $employee->status }}</span>
                    @else
                        <span class="badge badge-danger">{{ $employee->status }}</span>
                    @endif
                </td>
                <td style="color:var(--text3);font-size:12px">{{ \Carbon\Carbon::parse($employee->joined_date)->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:2rem;color:var(--text3)">Tiada pekerja lagi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('departmentChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartDepartmentLabels) !!},
        datasets: [{
            label: 'Employees',
            data: {!! json_encode($chartDepartmentData) !!},
            backgroundColor: '#4f46e5',
            borderRadius: 6,
            maxBarThickness: 40
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});

new Chart(document.getElementById('leaveChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Approved', 'Rejected'],
        datasets: [{
            data: [
                {{ $chartLeaveData['Pending'] }},
                {{ $chartLeaveData['Approved'] }},
                {{ $chartLeaveData['Rejected'] }}
            ],
            backgroundColor: ['#d97706', '#16a34a', '#dc2626'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>
@endpush
@endsection