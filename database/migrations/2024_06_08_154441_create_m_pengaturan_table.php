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
        Schema::create('m_pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('application_name');
            $table->string('application_short_name');
            $table->string('application_email');
            $table->string('application_contact', 20);
            $table->string('application_footer');
            $table->string('application_prefix_title');
            $table->text('application_description');
            $table->string('instagram_account')->nullable();
            $table->string('facebook_account')->nullable();
            $table->string('whatsapp_account')->nullable();
            $table->string('twitter_account')->nullable();
            $table->string('youtube_account')->nullable();
            $table->string('linkedin_account')->nullable();
            $table->string('application_logo')->nullable();
            $table->string('application_icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_pengaturan');
    }
};
