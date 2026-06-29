@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Audit Logs</h2>
        <p class="page-sub">Rekod semua aktiviti penting dalam sistem.</p>
    </div>
</div>

<div class="card">
    <form method="GET" action="{{ route('audit-logs.index') }}" style="display:flex;gap:10px;margin-bottom:1rem;flex-wrap:wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari description..." style="flex:1;min-width:200px;padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:14px">
        <select name="action" style="padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:14px">
            <option value="">All Actions</option>
            @foreach($actions as $action)
                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                    {{ str_replace('_', ' ', ucfirst($action)) }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn primary">Filter</button>
        <a href="{{ route('audit-logs.index') }}" class="btn">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>User</th>
                <th>Action</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr>
                <td style="color:var(--text3);font-size:12px;white-space:nowrap">
                    {{ $log->created_at->format('d M Y, h:i A') }}
                </td>
                <td style="font-weight:600">
                    {{ $log->user?->name ?? 'System' }}
                </td>
                <td>
                    @php
                        $badgeClass = match(true) {
                            str_contains($log->action, 'approved') || str_contains($log->action, 'created') => 'badge-success',
                            str_contains($log->action, 'rejected') || str_contains($log->action, 'deleted') => 'badge-danger',
                            str_contains($log->action, 'updated') => 'badge-warn',
                            default => 'badge-info',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ str_replace('_', ' ', $log->action) }}</span>
                </td>
                <td style="font-size:13px">{{ $log->description }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;padding:2rem;color:var(--text3)">Tiada rekod log lagi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $logs->links() }}</div>
</div>
@endsection