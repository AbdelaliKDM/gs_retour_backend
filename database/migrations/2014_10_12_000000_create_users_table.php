<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name')->nullable()->default(NULL);
      $table->string('email')->nullable()->default(NULL);
      $table->string('phone')->nullable()->default(NULL);
      $table->timestamp('email_verified_at')->nullable()->default(NULL);
      $table->timestamp('phone_verified_at')->nullable()->default(NULL);
      $table->string('password')->nullable()->default(NULL);
      $table->string('image')->nullable()->default(NULL);
      $table->string('id_card')->nullable()->default(NULL);
      $table->string('id_card_selfie')->nullable()->default(NULL);
      $table->enum('role', ['admin', 'driver', 'renter'])->nullable()->default(NULL);
      $table->enum('status', ['active', 'inactive', 'suspended', 'deleted'])->nullable()->default('inactive');
      $table->string('device_token')->nullable()->default(NULL);
      $table->rememberToken();
      $table->timestamps();
      $table->softDeletes();

      $table->unique('email');
      $table->unique('phone');

    });

    DB::statement('ALTER TABLE users ADD CONSTRAINT check_email_or_phone CHECK (email IS NOT NULL OR phone IS NOT NULL)');
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
};
