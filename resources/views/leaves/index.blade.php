@extends('layouts.app')

@section('title', 'Leave Management')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Leave Management</h2>
        <p class="page-sub">Manage all leave requests here.</p>
    </div>
    <a href="{{ route('leaves.create') }}" class="btn primary">
        <i class="ti ti-plus"></i> Apply Leave
    </a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaves as $leave)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <div class="emp-avatar" style="background:#4f46e5">
                            {{ strtoupper(substr($leave->employee->first_name,0,1).substr($leave->employee->last_name,0,1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600">{{ $leave->employee->full_name }}</div>
                            <div style="font-size:11px;color:var(--text3)">{{ $leave->employee->department->name ?? '-' }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $leave->leaveType->name }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                <td><span class="badge badge-info">{{ $leave->total_days }} day(s)</span></td>
                <td>
                    @if($leave->status == 'Approved')
                        <span class="badge badge-success">{{ $leave->status }}</span>
                    @elseif($leave->status == 'Pending')
                        <span class="badge badge-warn">{{ $leave->status }}</span>
                    @else
                        <span class="badge badge-danger">{{ $leave->status }}</span>
                    @endif
                </td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('leaves.show', $leave) }}" class="btn sm">
                            <i class="ti ti-eye"></i>
                        </a>
                        @if($leave->status == 'Pending')
                        <form method="POST" action="{{ route('leaves.approve', $leave) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn sm" style="background:#dcfce7;color:#16a34a;border-color:#bbf7d0">
                                <i class="ti ti-check"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('leaves.reject', $leave) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn sm danger" onclick="return confirm('Tolak permohonan ini?')">
                                <i class="ti ti-x"></i>
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('leaves.destroy', $leave) }}" onsubmit="return confirm('Padam permohonan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn sm danger">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:2rem;color:var(--text3)">
                    Tiada permohonan cuti lagi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $leaves->links() }}</div>
</div>
@endsection