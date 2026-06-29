@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-h2">Edit Employee</h2>
        <p class="page-sub">{{ $employee->full_name }}</p>
    </div>
    <a href="{{ route('employees.index') }}" class="btn">
        <i class="ti ti-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <form method="POST" action="{{ route('employees.update', $employee) }}">
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
                <label>First Name *</label>
                <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required>
            </div>
            <div class="form-group">
                <label>Last Name *</label>
                <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="{{ old('email', $employee->email) }}" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>IC No</label>
                <input type="text" name="ic_no" value="{{ old('ic_no', $employee->ic_no) }}">
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender">
                    <option value="">-- Select --</option>
                    <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Department *</label>
                <select name="department_id" required>
                    <option value="">-- Select Department --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Position *</label>
                <input type="text" name="position" value="{{ old('position', $employee->position) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Employment Type</label>
                <select name="employment_type">
                    <option value="Full-time" {{ old('employment_type', $employee->employment_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="Part-time" {{ old('employment_type', $employee->employment_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="Contract" {{ old('employment_type', $employee->employment_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Active" {{ old('status', $employee->status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="On leave" {{ old('status', $employee->status) == 'On leave' ? 'selected' : '' }}>On Leave</option>
                    <option value="Resigned" {{ old('status', $employee->status) == 'Resigned' ? 'selected' : '' }}>Resigned</option>
                    <option value="Terminated" {{ old('status', $employee->status) == 'Terminated' ? 'selected' : '' }}>Terminated</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Joined Date *</label>
                <input type="date" name="joined_date" value="{{ old('joined_date', $employee->joined_date) }}" required>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" rows="3">{{ old('address', $employee->address) }}</textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:1rem">
            <a href="{{ route('employees.index') }}" class="btn">Cancel</a>
            <button type="submit" class="btn primary">
                <i class="ti ti-device-floppy"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection