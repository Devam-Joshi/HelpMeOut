<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('pdf_name')->nullable()->after('certificate_number');
        });
    }

    public function down()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('pdf_name');
        });
    }
};
