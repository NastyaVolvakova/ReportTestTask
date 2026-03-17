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
        Schema::create('report_processes', function (Blueprint $table) {
            $table->id('rp_id');
            $table->string('rp_pid');
            $table->datetime('rp_start_datetime');
            $table->decimal('rp_exec_time')->nullable();
            $table->integer('ps_id')->unsigned();
            $table->foreign('ps_id')->references('ps_id')->on('process_statuses');
            $table->string('rp_file_save_path', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_processes');
    }
};
