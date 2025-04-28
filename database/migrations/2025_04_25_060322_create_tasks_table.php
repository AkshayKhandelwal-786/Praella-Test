<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Task;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $status = Task::STATUS;
        $priority = Task::PRIORITY;

        Schema::create('tasks', function (Blueprint $table) use($status, $priority) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('title')->nullable()->unique();
            $table->text('description')->nullable();
            $table->enum('priority', [$priority['low'], $priority['medium'], $priority['high']])->default($priority['low'])->index();
            $table->enum('status', [$status['todo'], $status['inprogress'], $status['done']])->default($status['todo'])->index();
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
            $table->index(['id', 'user_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
