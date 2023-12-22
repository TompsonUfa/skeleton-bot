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
        Schema::create('tg_groups', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('tid')->nullable(false)->index();
            $table->string('name')->nullable();
            $table->string('link')->nullable();
            $table->string('username')->nullable();
            $table->string('status')->default('member');
            $table->string('type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tg_groups');
    }
};
