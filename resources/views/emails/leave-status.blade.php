<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body{font-family:Arial,sans-serif;background:#f0f2ff;margin:0;padding:20px}
.container{max-width:600px;margin:0 auto;background:#fff;border-radius:10px;overflow:hidden}
.header{background:#4f46e5;padding:30px;text-align:center}
.header h1{color:#fff;margin:0;font-size:22px}
.body{padding:30px}
.status-badge{display:inline-block;padding:8px 20px;border-radius:20px;font-weight:700;font-size:16px;margin-bottom:20px}
.approved{background:#dcfce7;color:#16a34a}
.rejected{background:#fee2e2;color:#dc2626}
.info-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #e5e7eb;font-size:14px}
.info-label{color:#6b7280}
.info-value{font-weight:600}
.footer{background:#f9fafb;padding:20px;text-align:center;font-size:12px;color:#9ca3af}
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🏢 StaffHub</h1>
        <p style="color:#c7d2fe;margin:5px 0 0">Leave Request Update</p>
    </div>
    <div class="body">
        <p>Hi <strong>{{ $leave->employee?->full_name }}</strong>,</p>
        <p>Your leave request has been updated:</p>

        <div class="status-badge {{ strtolower($leave->status) }}">
            {{ $leave->status == 'Approved' ? '✅ Approved' : '❌ Rejected' }}
        </div>

        <div class="info-row">
            <span class="info-label">Leave Type</span>
            <span class="info-value">{{ $leave->leaveType?->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Start Date</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">End Date</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Days</span>
            <span class="info-value">{{ $leave->total_days }} day(s)</span>
        </div>
        @if($leave->remarks)
        <div class="info-row">
            <span class="info-label">Remarks</span>
            <span class="info-value">{{ $leave->remarks }}</span>
        </div>
        @endif

        <p style="margin-top:20px;font-size:14px;color:#6b7280">
            If you have any questions, please contact HR department.
        </p>
    </div>
    <div class="footer">
        This is an automated email from StaffHub. Please do not reply.
    </div>
</div>
</body>
</html>