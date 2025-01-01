<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_tokens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->index()->constrained()->cascadeOnUpdate()->cascadeOnUpdate();

            $table->string('token', 500)->index();
            $table->string('user_agent')->nullable();
            $table->ipAddress()->nullable();

            $table->dateTime('logout_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tokens');
    }
};
