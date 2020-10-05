<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemLogsTables extends Migration
{
    public function up(): void
    {
        Schema::create('disk_logs', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->bigInteger('used_space');
            $table->bigInteger('total_space');
            $table->timestamp('created_at')->index();
        });
        Schema::create('memory_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('used_space');
            $table->bigInteger('total_space');
            $table->timestamp('created_at')->index();
        });
        Schema::create('cpu_logs', function (Blueprint $table) {
            $table->id();
            $table->double('cpu_usage');
            $table->timestamp('created_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disk_logs');
        Schema::dropIfExists('memory_logs');
        Schema::dropIfExists('cpu_logs');
    }
}
