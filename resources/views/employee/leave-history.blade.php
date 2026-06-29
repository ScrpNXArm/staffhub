@extends('layouts.employee')

@section('title', 'Leave History')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Leave History</h2>
        <p class="page-sub">Semua permohonan cuti anda.</p>
    </div>
    <a href="{{ route('employee.apply-leave') }}" class="btn primary">
        <i class="ti ti-calendar-plus"></i> Apply Leave
    </a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaves as $leave)
            <tr>
                <td style="font-weight:600">{{ $leave->leaveType->name }}</td>
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
                <td style="color:var(--text2);font-size:13px">{{ $leave->remarks ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:2rem;color:var(--text3)">
                    Tiada permohonan cuti lagi. <a href="{{ route('employee.apply-leave') }}">Apply sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $leaves->links() }}</div>
</div>
@endsection