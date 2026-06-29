@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Employees</h2>
        <p class="page-sub">Manage all your staff members here.</p>
    </div>
    <a href="{{ route('employees.create') }}" class="btn primary">
        <i class="ti ti-plus"></i> Add Employee
    </a>
</div>

<div class="card">
    <div class="card">
    <form method="GET" action="{{ route('employees.index') }}" style="display:flex;gap:10px;margin-bottom:1rem">
        <input type="text" name="search" placeholder="Search name, email, employee no..." 
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
        <select name="status" style="padding:8px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:13px;outline:none">
            <option value="">All Status</option>
            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="On leave" {{ request('status') == 'On leave' ? 'selected' : '' }}>On Leave</option>
            <option value="Resigned" {{ request('status') == 'Resigned' ? 'selected' : '' }}>Resigned</option>
            <option value="Terminated" {{ request('status') == 'Terminated' ? 'selected' : '' }}>Terminated</option>
        </select>
        <button type="submit" class="btn primary">Search</button>
        <a href="{{ route('employees.index') }}" class="btn">Reset</a>
    </form>
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Employee No</th>
                <th>Department</th>
                <th>Position</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
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
                            <div style="font-size:11px;color:var(--text3)">{{ $employee->email }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:12px;color:var(--text3)">{{ $employee->employee_no }}</td>
                <td>{{ $employee->department->name ?? '-' }}</td>
                <td>{{ $employee->position }}</td>
                <td><span class="badge badge-info">{{ $employee->employment_type }}</span></td>
                <td>
                    @if($employee->status == 'Active')
                        <span class="badge badge-success">{{ $employee->status }}</span>
                    @elseif($employee->status == 'On leave')
                        <span class="badge badge-warn">{{ $employee->status }}</span>
                    @else
                        <span class="badge badge-danger">{{ $employee->status }}</span>
                    @endif
                </td>
                <td>
                    <div class="action-btns">
                <a href="{{ route('employees.show', $employee) }}" class="btn sm">
        <i class="ti ti-eye"></i>
    </a>
    <a href="{{ route('employees.edit', $employee) }}" class="btn sm">
        <i class="ti ti-edit"></i>
    </a>
    @if(!$employee->user_id)
    <a href="{{ route('employees.create-account', $employee) }}" class="btn sm" style="background:#dcfce7;color:#16a34a;border-color:#bbf7d0">
        <i class="ti ti-user-plus"></i>
    </a>
    @else
    <span class="btn sm" style="background:#e0f2fe;color:#0891b2;border-color:#bae6fd;cursor:default">
        <i class="ti ti-user-check"></i>
    </span>
    @endif
    <form method="POST" action="{{ route('employees.destroy', $employee) }}" onsubmit="return confirm('Padam pekerja ini?')">
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
                    Tiada pekerja lagi. <a href="{{ route('employees.create') }}">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $employees->links() }}</div>
</div>
@endsection