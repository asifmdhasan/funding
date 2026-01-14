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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->string('role')->default('customer');
            $table->string('profile_image')->nullable();
            
            //Date of Birth
            $table->date('dob')->nullable();


            // For OTP & password reset
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            
            //is_customer flag
            $table->boolean('is_customer')->default(true);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
