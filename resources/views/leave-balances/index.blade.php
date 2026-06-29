@extends('layouts.app')

@section('title', 'Leave Balance')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Leave Balance</h2>
        <p class="page-sub">Track baki cuti setiap pekerja untuk tahun {{ $year }}.</p>
    </div>
</div>

<div class="card">
    <form method="GET" action="{{ route('leave-balances.index') }}" style="display:flex;gap:10px;margin-bottom:1rem">
        <input type="text" name="search" placeholder="Search name, employee no..."
               value="{{ request('search') }}"
               style="flex:1;padding:8px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:13px;outline:none">
        <select name="department" style="padding:8px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:13px;outline:none">
            <option value="">All Departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
            @endforeach
        </select>
        <select name="year" style="padding:8px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:13px;outline:none">
            @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="btn primary">Filter</button>
        <a href="{{ route('leave-balances.index') }}" class="btn">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Department</th>
                @foreach($leaveTypes as $type)
                    <th style="text-align:center">{{ $type->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <div class="emp-avatar" style="background:#4f46e5">
                            {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600">{{ $employee->full_name }}</div>
                            <div style="font-size:11px;color:var(--text3)">{{ $employee->employee_no }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $employee->department->name ?? '-' }}</td>
                @foreach($leaveTypes as $type)
                    @php
                        $balance = $employee->leaveBalances->where('leave_type_id', $type->id)->first();
                    @endphp
                    <td style="text-align:center">
                        @if($balance)
                            <div style="font-size:13px">
                                <span style="color:var(--success);font-weight:700">{{ $balance->remaining_days }}</span>
                                <span style="color:var(--text3)"> / {{ $balance->entitled_days }}</span>
                            </div>
                            <div style="font-size:10px;color:var(--text3)">{{ $balance->used_days }} used</div>
                        @else
                            <span style="color:var(--text3)">-</span>
                        @endif
                    </td>
                @endforeach
            </tr>
            @empty
            <tr>
                <td colspan="{{ 2 + $leaveTypes->count() }}" style="text-align:center;padding:2rem;color:var(--text3)">
                    Tiada data.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $employees->links() }}</div>
</div>
@endsection