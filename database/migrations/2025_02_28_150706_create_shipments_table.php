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
        Schema::create('shipments', function (Blueprint $table) {
          $table->id();
          $table->foreignId('renter_id')->constrained('users');
          $table->foreignId('trip_id')->nullable()->default(null)->constrained('trips');
          $table->foreignId('truck_type_id')->constrained('truck_types');
          $table->foreignId('shipment_type_id')->constrained('shipment_types');
          $table->foreignId('starting_wilaya_id')->constrained('wilayas');
          $table->foreignId('arrival_wilaya_id')->constrained('wilayas');
          $table->decimal('starting_point_longitude');
          $table->decimal('starting_point_latitude');
          $table->decimal('arrival_point_longitude');
          $table->decimal('arrival_point_latitude');
          $table->dateTime('shipping_date');
          $table->decimal('waiting_hours')->default(0);
          $table->decimal('distance')->default(0);
          $table->decimal('price')->default(0);
          $table->decimal('weight')->default(0);
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
