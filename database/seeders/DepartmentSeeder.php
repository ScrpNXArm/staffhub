<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Engineering',  'code' => 'ENG'],
            ['name' => 'Marketing',    'code' => 'MKT'],
            ['name' => 'Finance',      'code' => 'FIN'],
            ['name' => 'HR',           'code' => 'HR'],
            ['name' => 'Operations',   'code' => 'OPS'],
        ];

        foreach ($departments as $dept) {
            DB::table('departments')->insert([
                'name'       => $dept['name'],
                'code'       => $dept['code'],
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}