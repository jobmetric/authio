<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use JobMetric\Authio\Enums\LoginTypeEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_otps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->index()->constrained()->cascadeOnUpdate();

            $table->string('source', 30)->index();
            /**
             * value: mobile, email
             *
             * use: @extends LoginTypeEnum
             */

            $table->string('secret', 30)->index();
            $table->string('otp', 8)->index();
            $table->ipAddress();
            $table->unsignedTinyInteger('try_count')->default(0);

            $table->dateTime('used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_otps');
    }
};
