<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->constrained();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('name_fr');
            $table->double('weight')->nullable()->default(null);
            $table->integer('capacity')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('truck_types');
    }
};
