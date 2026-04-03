<?php

use App\Enums\StreamStatuses;
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
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->enum('status', StreamStatuses::cases())->default(StreamStatuses::live);
            $table->string('thumbnail_url')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('ended_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streams');
    }
};
