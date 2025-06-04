<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category');
            $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled'])->default('open');
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->unsignedTinyInteger('story_points')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->foreignId('reporting_to')->nullable()->constrained('users');
            $table->json('tags')->nullable();
            $table->string('tenant')->nullable(); // recruitment, accounting, real_estate, crm
            $table->json('notifications')->nullable();
            $table->json('custom_fields')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}; 