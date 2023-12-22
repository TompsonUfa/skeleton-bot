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
        Schema::create('tg_users', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('tid');
            $table->integer('is_banned')->default(0);
            $table->integer('banned')->default(0);
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();

            $table->string('wallet')->default('');

            $table->string('referral_hash');
            $table->string('selected_language')->nullable();
            $table->integer('season_id')->default(0);
            $table->boolean('has_token')->default(0);
            $table->integer('referral_count')->default(0);
            $table->integer('referral_counted')->default(0);
            $table->integer('referral_id')->default(0);
            $table->timestamp('referral_at')->nullable();

            $table->timestamp('unlock_at')->nullable();

            $table->integer('captcha_passed')->default(0);
            $table->integer('captcha_attempts')->default(0);
            $table->integer('captcha_value')->default(0);

            $table->integer('captcha_subscribe')->default(0);

            $table->integer('last_action')->nullable();
            $table->timestamp('last_action_time')->nullable();
            $table->integer('action_notif_step')->default(0);

            $table->string('language_code')->nullable();

            $table->timestamp('last_checking_token_time')->nullable();

            $table->integer('referral_link_id')->default(0)->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tg_users');
    }
};
