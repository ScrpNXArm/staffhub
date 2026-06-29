<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Leave Report</title>
<style>
body{font-family:Arial,sans-serif;font-size:12px;color:#111}
h1{font-size:18px;margin-bottom:4px}
.subtitle{color:#666;font-size:12px;margin-bottom:20px}
table{width:100%;border-collapse:collapse}
th{background:#4f46e5;color:#fff;padding:8px;text-align:left;font-size:11px}
td{padding:8px;border-bottom:1px solid #e5e7eb;font-size:11px}
tr:nth-child(even){background:#f9fafb}
.badge{padding:2px 8px;border-radius:10px;font-size:10px;font-weight:600}
.approved{background:#dcfce7;color:#16a34a}
.pending{background:#fef3c7;color:#d97706}
.rejected{background:#fee2e2;color:#dc2626}
.footer{margin-top:20px;font-size:10px;color:#999;text-align:right}
</style>
</head>
<body>
<h1>StaffHub — Leave Report</h1>
<div class="subtitle">Generated on {{ now()->format('d M Y, h:i A') }}</div>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Employee</th>
            <th>Department</th>
            <th>Leave Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Days</th>
            <th>Status</th>
            <th>Reason</th>
        </tr>
    </thead>
    <tbody>
        @foreach($leaves as $i => $leave)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $leave->employee?->full_name ?? '-' }}</td>
            <td>{{ $leave->employee?->department?->name ?? '-' }}</td>
            <td>{{ $leave->leaveType?->name ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
            <td>{{ $leave->total_days }} day(s)</td>
            <td>
                <span class="badge {{ strtolower($leave->status) }}">
                    {{ $leave->status }}
                </span>
            </td>
            <td>{{ $leave->reason ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">Total: {{ $leaves->count() }} leave requests</div>
</body>
</html>