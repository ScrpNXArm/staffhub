<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('month'); // contoh: 'January'
            $table->integer('year'); // contoh: 2026
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('allowance', 10, 2)->default(0);
            $table->decimal('overtime', 10, 2)->default(0);
            $table->decimal('epf_deduction', 10, 2)->default(0);
            $table->decimal('socso_deduction', 10, 2)->default(0);
            $table->decimal('pcb_deduction', 10, 2)->default(0);
            $table->decimal('other_deduction', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2);
            $table->foreignId('generated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->unique(['employee_id', 'month', 'year']); // elak duplicate payslip bulan yang sama
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};