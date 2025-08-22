<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('job')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('age')->default(0);
            $table->foreignId('position_id')->references('id')->on('positions');
            $table->foreignId('gender_id')->references('id')->on('genders');
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->foreignId('father_id')->nullable()->constrained('persons');
            $table->foreignId('mother_id')->nullable()->constrained('persons');
            $table->unsignedInteger('spouse_id')->nullable();
            $table->foreignId('image_id')->nullable()->constrained('images');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
