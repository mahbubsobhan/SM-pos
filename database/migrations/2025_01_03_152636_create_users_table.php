<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id(); // Primary Key
        $table->string('firstName', 17); // First Name (Max Length: 17)
        $table->string('lastName', 10); // Last Name (Max Length: 10)
        $table->string('email', 100)->unique(); // Email (Unique, Max Length: 100)
        $table->string('mobile', 15)->unique()->default('N/A');
        $table->string('password', 255); // Password (Hashed, Max Length: 255)
        $table->string('otp', 6)->nullable(); // OTP (Optional, Max Length: 6)
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
