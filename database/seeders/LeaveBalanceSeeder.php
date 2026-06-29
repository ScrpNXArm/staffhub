<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveBalance;

class LeaveBalanceSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $leaveTypes = LeaveType::where('is_active', true)->get();
        $year = date('Y');

        foreach ($employees as $employee) {
            foreach ($leaveTypes as $leaveType) {
                LeaveBalance::create([
                    'employee_id'    => $employee->id,
                    'leave_type_id'  => $leaveType->id,
                    'year'           => $year,
                    'entitled_days'  => $leaveType->days_allowed,
                    'used_days'      => 0,
                    'remaining_days' => $leaveType->days_allowed,
                ]);
            }
        }
    }
}