<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add two more emergency contacts (2nd family, 1 friend) and unique phone constraint.
     * Contact 1 = existing fields (family)
     * Contact 2 = second family member
     * Contact 3 = friend
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Make phone unique so no two users can share the same number
            $table->string('phone')->unique()->change();

            // ── Emergency Contact 2 (Family) ──
            $table->string('emergency_contact2_name')->nullable()->after('relation');
            $table->string('emergency_contact2_phone')->nullable()->after('emergency_contact2_name');
            $table->string('emergency_contact2_relation')->nullable()->after('emergency_contact2_phone');

            // ── Emergency Contact 3 (Friend) ──
            $table->string('emergency_contact3_name')->nullable()->after('emergency_contact2_relation');
            $table->string('emergency_contact3_phone')->nullable()->after('emergency_contact3_name');
            $table->string('emergency_contact3_relation')->nullable()->after('emergency_contact3_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'emergency_contact2_name',
                'emergency_contact2_phone',
                'emergency_contact2_relation',
                'emergency_contact3_name',
                'emergency_contact3_phone',
                'emergency_contact3_relation',
            ]);
        });
    }
};
