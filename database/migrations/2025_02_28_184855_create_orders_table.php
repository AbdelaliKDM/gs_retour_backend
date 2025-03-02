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
        Schema::create('orders', function (Blueprint $table) {
          $table->id();
          $table->foreignId('trip_id')->constrained('trips');
          $table->foreignId('shipment_id')->constrained('shipments');
          $table->enum('status', ['pending','accepted','rejected'])->default('pending');
          $table->foreignId('created_by')->nullable()->constrained('users');
          $table->foreignId('updated_by')->nullable()->constrained('users');
          $table->foreignId('deleted_by')->nullable()->constrained('users');
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
