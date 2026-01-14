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
        Schema::table('gme_business_forms', function (Blueprint $table) {
            // Make fields nullable that are filled in steps
            $table->string('business_name')->nullable()->change();
            $table->text('short_introduction')->nullable()->change();
            $table->string('year_established')->nullable()->change();
            $table->unsignedBigInteger('business_category_id')->nullable()->change();
            $table->json('countries_of_operation')->nullable()->change();
            $table->text('business_address')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('whatsapp_number')->nullable()->change();
            $table->string('website')->nullable()->change();
            $table->json('founders')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gme_business_forms', function (Blueprint $table) {
            $table->string('business_name')->nullable(false)->change();
            $table->text('short_introduction')->nullable(false)->change();
            $table->string('year_established')->nullable(false)->change();
            $table->unsignedBigInteger('business_category_id')->nullable(false)->change();
            $table->json('countries_of_operation')->nullable(false)->change();
            $table->text('business_address')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('whatsapp_number')->nullable(false)->change();
            $table->string('website')->nullable(false)->change();
            $table->json('founders')->nullable(false)->change();
        });
    }
};
