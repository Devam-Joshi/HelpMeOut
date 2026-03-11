<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('complains', function (Blueprint $table) {
            $table->boolean('is_certificate_generate')->default(0);
            $table->boolean('is_payment_created')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complains', function (Blueprint $table) {
            //
        });
    }
};
