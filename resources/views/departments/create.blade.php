@extends('layouts.app')

@section('title', 'Add Department')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Add Department</h2>
        <p class="page-sub">Create a new department.</p>
    </div>
    <a href="{{ route('departments.index') }}" class="btn">
        <i class="ti ti-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <form method="POST" action="{{ route('departments.store') }}">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0;padding-left:1rem">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-row">
            <div class="form-group">
                <label>Department Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Information Technology" required>
            </div>
            <div class="form-group">
                <label>Department Code *</label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="e.g. IT" required>
            </div>
        </div>

        <div class="form-group">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                <input type="checkbox" name="is_active" value="1" checked style="width:auto">
                Active
            </label>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:1rem">
            <a href="{{ route('departments.index') }}" class="btn">Cancel</a>
            <button type="submit" class="btn primary">
                <i class="ti ti-plus"></i> Add Department
            </button>
        </div>
    </form>
</div>
@endsection