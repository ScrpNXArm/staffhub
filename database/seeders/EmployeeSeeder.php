<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            ['first_name' => 'Ahmad', 'last_name' => 'Razif', 'email' => 'ahmad.razif@staffhub.my', 'phone' => '0112345678', 'ic_no' => '900101-14-1234', 'gender' => 'Male', 'department_id' => 1, 'position' => 'Software Engineer', 'employment_type' => 'Full-time', 'status' => 'Active', 'joined_date' => '2022-01-10'],
            ['first_name' => 'Nurul', 'last_name' => 'Ain', 'email' => 'nurul.ain@staffhub.my', 'phone' => '0123456789', 'ic_no' => '920202-10-5678', 'gender' => 'Female', 'department_id' => 2, 'position' => 'Marketing Executive', 'employment_type' => 'Full-time', 'status' => 'Active', 'joined_date' => '2021-03-15'],
            ['first_name' => 'Muhammad', 'last_name' => 'Hafiz', 'email' => 'muhammad.hafiz@staffhub.my', 'phone' => '0134567890', 'ic_no' => '880303-06-9012', 'gender' => 'Male', 'department_id' => 3, 'position' => 'Finance Manager', 'employment_type' => 'Full-time', 'status' => 'Active', 'joined_date' => '2019-06-01'],
            ['first_name' => 'Siti', 'last_name' => 'Rahmah', 'email' => 'siti.rahmah@staffhub.my', 'phone' => '0145678901', 'ic_no' => '950404-08-3456', 'gender' => 'Female', 'department_id' => 4, 'position' => 'HR Executive', 'employment_type' => 'Full-time', 'status' => 'Active', 'joined_date' => '2023-02-20'],
            ['first_name' => 'Faizal', 'last_name' => 'Ismail', 'email' => 'faizal.ismail@staffhub.my', 'phone' => '0156789012', 'ic_no' => '870505-12-7890', 'gender' => 'Male', 'department_id' => 5, 'position' => 'Operations Manager', 'employment_type' => 'Full-time', 'status' => 'Active', 'joined_date' => '2018-09-15'],
            ['first_name' => 'Amirah', 'last_name' => 'Zulkifli', 'email' => 'amirah.zulkifli@staffhub.my', 'phone' => '0167890123', 'ic_no' => '930606-14-2345', 'gender' => 'Female', 'department_id' => 1, 'position' => 'Frontend Developer', 'employment_type' => 'Full-time', 'status' => 'Active', 'joined_date' => '2022-07-01'],
            ['first_name' => 'Khairul', 'last_name' => 'Anwar', 'email' => 'khairul.anwar@staffhub.my', 'phone' => '0178901234', 'ic_no' => '910707-10-6789', 'gender' => 'Male', 'department_id' => 2, 'position' => 'Digital Marketing', 'employment_type' => 'Contract', 'status' => 'Active', 'joined_date' => '2023-04-10'],
            ['first_name' => 'Nor', 'last_name' => 'Hidayah', 'email' => 'nor.hidayah@staffhub.my', 'phone' => '0189012345', 'ic_no' => '960808-06-0123', 'gender' => 'Female', 'department_id' => 3, 'position' => 'Accountant', 'employment_type' => 'Full-time', 'status' => 'Active', 'joined_date' => '2021-11-30'],
            ['first_name' => 'Zulhilmi', 'last_name' => 'Hassan', 'email' => 'zulhilmi.hassan@staffhub.my', 'phone' => '0190123456', 'ic_no' => '850909-08-4567', 'gender' => 'Male', 'department_id' => 4, 'position' => 'HR Manager', 'employment_type' => 'Full-time', 'status' => 'Active', 'joined_date' => '2017-03-01'],
            ['first_name' => 'Farhana', 'last_name' => 'Mohd', 'email' => 'farhana.mohd@staffhub.my', 'phone' => '0111234567', 'ic_no' => '941010-12-8901', 'gender' => 'Female', 'department_id' => 5, 'position' => 'Operations Executive', 'employment_type' => 'Part-time', 'status' => 'On leave', 'joined_date' => '2022-05-16'],
        ];

        foreach ($employees as $i => $emp) {
            Employee::create([
                ...$emp,
                'employee_no' => 'EMP-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'date_of_birth' => null,
                'address' => null,
                'created_by' => null,
            ]);
        }
    }
}