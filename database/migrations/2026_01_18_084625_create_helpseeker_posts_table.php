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
        Schema::create('helpseeker_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('helpseeker_id')->constrained()->cascadeOnDelete();
            $table->string('title');              // Post title
            $table->text('reason');               // Why they need help
            $table->decimal('required_amount', 12, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helpseeker_posts');
    }
};
