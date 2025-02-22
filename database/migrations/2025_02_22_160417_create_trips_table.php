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
        Schema::create('trips', function (Blueprint $table) {
          $table->id();
          $table->foreignId('driver_id')->constrained('users');
          $table->foreignId('truck_id')->constrained();
          $table->foreignId('starting_wilaya_id')->constrained('wilayas');
          $table->foreignId('arrival_wilaya_id')->constrained('wilayas');
          $table->decimal('starting_point_longitude');
          $table->decimal('starting_point_latitude');
          $table->decimal('arrival_point_longitude');
          $table->decimal('arrival_point_latitude');
          $table->decimal('distance');
          $table->datetime('starts_at');
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
