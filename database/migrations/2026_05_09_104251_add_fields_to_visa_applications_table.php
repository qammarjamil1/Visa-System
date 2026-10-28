<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visa_applications', function (Blueprint $table) {
            $table->string('email')->nullable()->after('full_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('country')->nullable()->after('visa_type');
            $table->integer('duration_days')->nullable()->after('travel_date');
            $table->text('purpose')->nullable()->after('duration_days');
            $table->text('notes')->nullable()->after('purpose');
            $table->text('admin_notes')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('visa_applications', function (Blueprint $table) {
            $table->dropColumn(['email','phone','country','duration_days','purpose','notes','admin_notes']);
        });
    }
};