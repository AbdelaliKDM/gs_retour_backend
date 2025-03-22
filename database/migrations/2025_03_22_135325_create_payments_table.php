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
        Schema::create('payments', function (Blueprint $table) {
          $table->id();
          $table->morphs('payable');
          $table->double('amount');
          $table->enum('payment_method', ['wallet', 'chargily', 'ccp', 'baridi'])->nullable();
          $table->enum('status', ['pending', 'failed', 'paid'])->default('pending');
          $table->timestamp('paid_at')->nullable();
          $table->string('account')->nullable();
          $table->string('receipt')->nullable();
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
