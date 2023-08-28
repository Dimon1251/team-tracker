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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->integer('estimation');
            $table->string('status')->default('todo');
            $table->integer('order')->default(50);

            $table->unsignedBigInteger('sprint_id')->nullable();
            $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
            $table->unsignedBigInteger('assignee_user_id')->nullable();
            $table->foreign('assignee_user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('assigned_user_id')->nullable();
            $table->foreign('assigned_user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
