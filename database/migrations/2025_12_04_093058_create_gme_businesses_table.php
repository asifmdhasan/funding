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

        Schema::create('gme_businesses', function (Blueprint $table) {
            $table->id();

            // Business Identity
            $table->string('business_name');
            $table->text('short_introduction')->nullable();
            $table->string('year_established')->nullable();
            
            $table->foreignId('business_category_id')->nullable()->constrained('business_categories')->nullOnDelete();

            $table->json('countries_of_operation')->nullable(); // Multi-country support
            $table->text('business_address')->nullable();
            $table->string('email');
            $table->string('whatsapp_number');
            $table->string('website')->nullable();
            
            // Social Links (Optional)
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('online_store')->nullable();

            // Founder Information (Multi-founder support via separate table recommended)
            // But keeping basic founder info here for backwards compatibility
            $table->json('founders')->nullable(); // Stores array of founder objects

            // Business Size & Structure
            $table->enum('registration_status', [
                'registered_company',
                'sole_proprietorship',
                'partnership',
                'startup_early_stage',
                'home_based',
                'not_registered_yet'
            ])->nullable();
            
            $table->enum('employee_count', [
                '1-3',
                '4-10',
                '11-25',
                '26-50',
                '51+'
            ])->nullable();
            
            $table->enum('operational_scale', [
                'local',
                'nationwide',
                'international',
                'online_only',
                'hybrid'
            ])->nullable();
            
            $table->enum('annual_revenue', [
                'under_10k',
                '10k-50k',
                '50k-200k',
                '200k-1m',
                'above_1m'
            ])->nullable();

            // Business Description
            $table->text('business_overview')->nullable(); // max 300 words
            $table->json('services_id')->nullable(); // List of Products/Services (up to 10)
            
            // File Uploads
            $table->string('registration_document')->nullable();
            $table->string('logo')->nullable(); // PNG preferred
            $table->string('cover_photo')->nullable();
            $table->json('photos')->nullable(); // 3-6 photos
            $table->string('business_profile')->nullable();
            $table->string('product_catalogue')->nullable();

            // Islamic Ethical Alignment
            $table->enum('avoid_riba', [
                'yes',
                'partially_transitioning',
                'no',
                'prefer_not_to_say'
            ])->nullable();
            
            $table->enum('avoid_haram_products', [
                'yes',
                'partially_compliant',
                'no'
            ])->nullable();
            
            $table->enum('fair_pricing', [
                'yes',
                'mostly',
                'needs_improvement'
            ])->nullable();
            
            $table->text('ethical_description')->nullable(); // 100-200 words
            
            $table->enum('open_for_guidance', [
                'yes',
                'no',
                'maybe'
            ])->nullable();

            // Collaboration & Community
            $table->enum('collaboration_open', [
                'yes',
                'no',
                'maybe'
            ])->nullable();
            
            $table->json('collaboration_types')->nullable(); // Multiple selection
            // Values: partnerships, investment_opportunities, vendor_supply_chain, 
            // marketing_promotion, networking, training_workshops, 
            // community_charity_projects, not_sure_yet

            // Consent & Approval
            $table->boolean('info_accuracy')->default(false); // Must be checked
            $table->boolean('allow_publish')->default(false); // Yes/No
            $table->boolean('allow_contact')->default(false); // Must be checked
            $table->string('digital_signature')->nullable(); // Full Name + Date

            // Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
            
            // Foreign Keys
            // $table->foreign('business_category_id')
            //     ->references('id')
            //     ->on('business_categories')
            //     ->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gme_businesses');
    }
};
