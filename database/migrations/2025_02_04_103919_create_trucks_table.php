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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('truck_type_id')->constrained();
            $table->string('serial_number')->nullable()->default(null);
            $table->string('gray_card')->nullable()->default(null);
            $table->string('driving_license')->nullable()->default(null);
            $table->string('insurance_certificate')->nullable()->default(null);
            $table->date('insurance_expiry_date')->nullable()->default(null);
            $table->string('inspection_certificate')->nullable()->default(null);
            $table->date('next_inspection_date')->nullable()->default(null);
            $table->boolean('affiliated_with_agency')->nullable()->default(null);
            $table->string('agency_document')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
