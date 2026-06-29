<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Employee Report</title>
<style>
body{font-family:Arial,sans-serif;font-size:12px;color:#111}
h1{font-size:18px;margin-bottom:4px}
.subtitle{color:#666;font-size:12px;margin-bottom:20px}
table{width:100%;border-collapse:collapse}
th{background:#4f46e5;color:#fff;padding:8px;text-align:left;font-size:11px}
td{padding:8px;border-bottom:1px solid #e5e7eb;font-size:11px}
tr:nth-child(even){background:#f9fafb}
.badge{padding:2px 8px;border-radius:10px;font-size:10px;font-weight:600}
.active{background:#dcfce7;color:#16a34a}
.on-leave{background:#fef3c7;color:#d97706}
.other{background:#fee2e2;color:#dc2626}
.footer{margin-top:20px;font-size:10px;color:#999;text-align:right}
</style>
</head>
<body>
<h1>StaffHub — Employee Report</h1>
<div class="subtitle">Generated on {{ now()->format('d M Y, h:i A') }}</div>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Employee No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Position</th>
            <th>Type</th>
            <th>Status</th>
            <th>Joined</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $i => $employee)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $employee->employee_no }}</td>
            <td>{{ $employee->full_name }}</td>
            <td>{{ $employee->email }}</td>
            <td>{{ $employee->department->name ?? '-' }}</td>
            <td>{{ $employee->position }}</td>
            <td>{{ $employee->employment_type }}</td>
            <td>
                <span class="badge {{ $employee->status == 'Active' ? 'active' : ($employee->status == 'On leave' ? 'on-leave' : 'other') }}">
                    {{ $employee->status }}
                </span>
            </td>
            <td>{{ \Carbon\Carbon::parse($employee->joined_date)->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">Total: {{ $employees->count() }} employees</div>
</body>
</html>