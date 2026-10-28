<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visa_leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('visa_type')->nullable();
            $table->string('country')->nullable();
            $table->string('status')->default('interested'); // interested | completed
            $table->timestamps();

            $table->unique('user_id'); // har user ka sirf 1 lead record rahe (upsert hoga)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visa_leads');
    }
};