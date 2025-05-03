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
        // This migration is no longer needed as we're using job_applications table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No actions required
    }
};
