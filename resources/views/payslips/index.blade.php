@extends('layouts.app')

@section('title', 'Payslips')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Payslips</h2>
        <p class="page-sub">Jana dan urus slip gaji pekerja.</p>
    </div>
    <a href="{{ route('payslips.create') }}" class="btn primary">
        <i class="ti ti-plus"></i> Generate Payslip
    </a>
</div>

<div class="card">
    <form method="GET" action="{{ route('payslips.index') }}" style="display:flex;gap:10px;margin-bottom:1rem;flex-wrap:wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / no pekerja..." style="flex:1;min-width:200px;padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:14px">
        <select name="month" style="padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:14px">
            <option value="">All Months</option>
            @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
        </select>
        <select name="year" style="padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:14px">
            <option value="">All Years</option>
            @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="btn primary">Filter</button>
        <a href="{{ route('payslips.index') }}" class="btn">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Department</th>
                <th>Period</th>
                <th>Basic Salary</th>
                <th>Net Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payslips as $payslip)
            <tr>
                <td style="font-weight:600">{{ $payslip->employee->full_name }}</td>
                <td>{{ $payslip->employee->department->name ?? '-' }}</td>
                <td>{{ $payslip->month }} {{ $payslip->year }}</td>
                <td>RM {{ number_format($payslip->basic_salary, 2) }}</td>
                <td style="font-weight:700;color:var(--success)">RM {{ number_format($payslip->net_salary, 2) }}</td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('payslips.show', $payslip) }}" class="btn sm">
                            <i class="ti ti-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('payslips.destroy', $payslip) }}" onsubmit="return confirm('Padam payslip ini?')">
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
                <td colspan="6" style="text-align:center;padding:2rem;color:var(--text3)">
                    Tiada payslip lagi. <a href="{{ route('payslips.create') }}">Jana sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $payslips->links() }}</div>
</div>
@endsection