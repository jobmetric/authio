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
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();

            $table->string('mobile_prefix', 20)->nullable()->index()->after('email_verified_at');
            $table->string('mobile', 20)->nullable()->index()->after('mobile_prefix');
            $table->timestamp('mobile_verified_at')->nullable()->after('mobile');

            $table->softDeletes()->after('remember_token');

            $table->unique([
                'mobile_prefix',
                'mobile',
            ], 'MOBILE_UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('MOBILE_UNIQUE');

            $table->dropColumn('mobile_prefix');
            $table->dropColumn('mobile');
            $table->dropColumn('mobile_verified_at');

            $table->dropColumn('deleted_at');

            $table->string('email')->change();
            $table->string('password')->change();
        });
    }
};
