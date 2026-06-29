<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            ['name' => 'Annual Leave',    'days_allowed' => 12],
            ['name' => 'Sick Leave',      'days_allowed' => 14],
            ['name' => 'Emergency Leave', 'days_allowed' => 3],
            ['name' => 'Maternity Leave', 'days_allowed' => 60],
            ['name' => 'Paternity Leave', 'days_allowed' => 3],
            ['name' => 'Unpaid Leave',    'days_allowed' => 0],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::create([
                'name'         => $type['name'],
                'days_allowed' => $type['days_allowed'],
                'is_active'    => true,
            ]);
        }
    }
}