<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'basic_salary',
        'allowance',
        'overtime',
        'epf_deduction',
        'socso_deduction',
        'pcb_deduction',
        'other_deduction',
        'net_salary',
        'generated_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    // Helper untuk kira gross salary
    public function getGrossSalaryAttribute()
    {
        return $this->basic_salary + $this->allowance + $this->overtime;
    }

    // Helper untuk kira total deduction
    public function getTotalDeductionAttribute()
    {
        return $this->epf_deduction + $this->socso_deduction + $this->pcb_deduction + $this->other_deduction;
    }
}