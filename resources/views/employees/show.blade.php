@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Employee Details</h2>
        <p class="page-sub">{{ $employee->full_name }}</p>
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('employees.edit', $employee) }}" class="btn primary">
            <i class="ti ti-edit"></i> Edit
        </a>
        <a href="{{ route('employees.index') }}" class="btn">
            <i class="ti ti-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card">
    <div style="display:flex;align-items:center;gap:20px;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border)">
        <div class="emp-avatar" style="width:64px;height:64px;font-size:22px;background:#4f46e5">
            {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
        </div>
        <div>
            <div style="font-size:20px;font-weight:700">{{ $employee->full_name }}</div>
            <div style="color:var(--text2)">{{ $employee->position }}</div>
            <div style="font-size:12px;color:var(--text3);margin-top:4px">{{ $employee->employee_no }}</div>
        </div>
        <div style="margin-left:auto">
            @if($employee->status == 'Active')
                <span class="badge badge-success" style="font-size:14px;padding:6px 16px">{{ $employee->status }}</span>
            @elseif($employee->status == 'On leave')
                <span class="badge badge-warn" style="font-size:14px;padding:6px 16px">{{ $employee->status }}</span>
            @else
                <span class="badge badge-danger" style="font-size:14px;padding:6px 16px">{{ $employee->status }}</span>
            @endif
        </div>
    </div>

    <div class="form-row">
        <div>
            <div style="font-size:12px;color:var(--text3);margin-bottom:4px">Email</div>
            <div>{{ $employee->email }}</div>