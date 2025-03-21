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
        Schema::create('notices', function (Blueprint $table) {
          $table->id();
          $table->string('title_ar');
          $table->string('title_en');
          $table->string('title_fr');
          $table->text('content_ar');
          $table->text('content_en');
          $table->text('content_fr');
          $table->smallInteger('type')->default(0);
          $table->smallInteger('priority')->default(0);
          $table->json('metadata')->nullable();
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
