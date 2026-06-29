<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LeaveBalanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\PayslipController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    // Redirect ikut role lepas login
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('hr_admin') || $user->hasRole('super_admin') || $user->hasRole('manager')) {
            return app(DashboardController::class)->index();
        }
        return redirect()->route('employee.dashboard');
    })->name('dashboard');

    // HR Admin & Manager routes
    Route::middleware(['role:hr_admin|super_admin|manager'])->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::get('employees/{employee}/create-account', [EmployeeController::class, 'createAccount'])->name('employees.create-account');
        Route::post('employees/{employee}/store-account', [EmployeeController::class, 'storeAccount'])->name('employees.store-account');
        Route::resource('departments', DepartmentController::class);
        Route::resource('leaves', LeaveController::class);
        Route::patch('leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
        Route::patch('leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/reports/export-employees-pdf', [ReportController::class, 'exportEmployeesPdf'])->name('reports.employees.pdf');
        Route::get('/reports/export-leaves-pdf', [ReportController::class, 'exportLeavesPdf'])->name('reports.leaves.pdf');
        Route::get('/leave-balances', [LeaveBalanceController::class, 'index'])->name('leave-balances.index');
        Route::resource('payslips', PayslipController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    });

    // HR Admin & Super Admin only routes
    Route::middleware(['role:hr_admin|super_admin'])->group(function () {
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });

    // Employee routes
    Route::middleware(['role:employee'])->group(function () {
        Route::get('/my-dashboard', [EmployeeDashboardController::class, 'dashboard'])->name('employee.dashboard');
        Route::get('/my-profile', [EmployeeDashboardController::class, 'profile'])->name('employee.profile');
        Route::get('/my-leave', [EmployeeDashboardController::class, 'applyLeave'])->name('employee.apply-leave');
        Route::post('/my-leave', [EmployeeDashboardController::class, 'storeLeave'])->name('employee.store-leave');
        Route::get('/my-leave-history', [EmployeeDashboardController::class, 'leaveHistory'])->name('employee.leave-history');
    });

});

require __DIR__.'/auth.php';