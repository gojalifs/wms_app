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
        Schema::create('intake_orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->string('supplier');
            $table->date('received_at');
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intake_orders');
    }
};
