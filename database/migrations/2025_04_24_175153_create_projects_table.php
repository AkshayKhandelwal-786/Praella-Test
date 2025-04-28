<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Project;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $status = Project::STATUS;

        Schema::create('projects', function (Blueprint $table) use ($status) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable()->unique();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default($status['Inactive'])->comment($status['Inactive'] . '=Inactive,' . $status['Active'] . '=Active')->index();
            $table->timestamps();
            $table->index(['id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
