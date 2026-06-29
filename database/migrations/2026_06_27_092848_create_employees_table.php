<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_no', 20)->unique();
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->string('email', 150)->unique();
            $table->string('phone', 20)->nullable();
            $table->string('ic_no', 20)->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('department_id')->constrained('departments');
            $table->string('position', 100);
            $table->enum('employment_type', ['Full-time', 'Part-time', 'Contract'])->default('Full-time');
            $table->enum('status', ['Active', 'On leave', 'Resigned', 'Terminated'])->default('Active');
            $table->date('joined_date');
            $table->date('resigned_date')->nullable();
            $table->string('photo', 255)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};