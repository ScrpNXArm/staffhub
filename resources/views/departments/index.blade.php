@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Departments</h2>
        <p class="page-sub">Manage all departments in your organisation.</p>
    </div>
    <a href="{{ route('departments.create') }}" class="btn primary">
        <i class="ti ti-plus"></i> Add Department
    </a>
</div>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Department Name</th>
                <th>Code</th>
                <th>Total Employees</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $department)
            <tr>
                <td style="font-weight:600">{{ $department->name }}</td>
                <td><span class="badge badge-info">{{ $department->code }}</span></td>
                <td>{{ $department->employees_count }} employee(s)</td>
                <td>
                    @if($department->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('departments.edit', $department) }}" class="btn sm">
                            <i class="ti ti-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('departments.destroy', $department) }}" onsubmit="return confirm('Padam department ini?')">
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
                <td colspan="5" style="text-align:center;padding:2rem;color:var(--text3)">
                    Tiada department lagi. <a href="{{ route('departments.create') }}">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $departments->links() }}</div>
</div>
@endsection