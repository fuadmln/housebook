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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('province_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->foreignId('subdistrict_id')->constrained();

            $table->decimal('price', 12, 2);
            $table->string('address');
            $table->string('description')->nullable();
            $table->tinyInteger('type');
            $table->integer('building_area');
            $table->integer('land_length');
            $table->integer('land_width');
            $table->integer('bedroom');
            $table->integer('bathroom');
            $table->integer('floor');
            $table->string('headline');
            $table->text('iframe')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
