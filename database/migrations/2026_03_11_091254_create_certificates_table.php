<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            $table->integer('complaint_id')->nullable();
            $table->string('certificate_number')->unique();

            $table->string('issued_to');
            $table->date('issue_date');

            $table->string('no_of_pc')->nullable();
            $table->string('serial_no')->nullable();

            $table->string('fire_extinguisher_type')->nullable();

            $table->date('next_due_date')->nullable();
            $table->date('certificate_valid_date')->nullable();

            $table->string('parts')->default('OK');
            $table->string('hy_test')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};