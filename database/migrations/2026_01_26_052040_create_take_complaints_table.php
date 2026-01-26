<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('take_complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_id');
            $table->unsignedBigInteger('agent_id');
            $table->timestamps();

            // optional but recommended
            $table->foreign('complaint_id')
                  ->references('id')
                  ->on('complains')
                  ->onDelete('cascade');

            $table->foreign('agent_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // prevent same complaint taken twice by same agent
            $table->unique(['complaint_id', 'agent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('take_complaints');
    }
};
