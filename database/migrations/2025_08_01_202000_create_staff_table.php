<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('position');
            $table->string('department')->nullable();
            $table->date('hire_date');
            $table->enum('status', ['active', 'inactive', 'on_leave', 'terminated'])->default('active');
            $table->string('employee_id')->unique();
            $table->text('address')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('skills')->nullable();
            $table->decimal('hourly_rate', 8, 2)->default(0);
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
}; 