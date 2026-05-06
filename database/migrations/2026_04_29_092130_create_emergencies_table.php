<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Create the emergencies table.
     */
    public function up(): void
    {
        Schema::create('emergencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Linked user
            $table->decimal('latitude', 10, 8)->nullable();     // GPS latitude
            $table->decimal('longitude', 11, 8)->nullable();    // GPS longitude
            $table->string('address')->nullable();               // Manual address if GPS denied
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('high');
            $table->enum('status', ['pending', 'accepted', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->text('notes')->nullable();                  // Additional emergency details
            $table->timestamp('accepted_at')->nullable();       // When admin accepted
            $table->timestamp('completed_at')->nullable();      // When emergency completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergencies');
    }
};
