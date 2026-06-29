@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Edit Department</h2>
        <p class="page-sub">{{ $department->name }}</p>
    </div>
    <a href="{{ route('departments.index') }}" class="btn">
        <i class="ti ti-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <form method="POST" action="{{ route('departments.update', $department) }}">
        @csrf
        @method('PUT')

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
                <input type="text" name="name" value="{{ old('name', $department->name) }}" required>
            </div>
            <div class="form-group">
                <label>Department Code *</label>
                <input type="text" name="code" value="{{ old('code', $department->code) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                <input type="checkbox" name="is_active" value="1" 
                    {{ old('is_active', $department->is_active) ? 'checked' : '' }}
                    style="width:auto">
                Active
            </label>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:1rem">
            <a href="{{ route('departments.index') }}" class="btn">Cancel</a>
            <button type="submit" class="btn primary">
                <i class="ti ti-device-floppy"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection