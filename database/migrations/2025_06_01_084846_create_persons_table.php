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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('job')->nullable();
            $table->date('birth')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('birthcountry', 3)->default('FRA');
            $table->date('death')->nullable();
            $table->string('deathplace')->nullable();
            $table->string('deathcountry', 3)->nullable();
            $table->enum('gender', ['F', 'M'])->default('M');
            $table->unsignedInteger('father')->nullable();
            $table->unsignedInteger('mother')->nullable();
            $table->unsignedInteger('spouse')->nullable();
            $table->unsignedInteger('generation')->default(1);
            $table->unsignedInteger('age')->default(0);
            $table->string('photo')->nullable();
            $table->string('birth_act')->nullable();
            $table->string('death_act')->nullable();
            $table->string('other_img')->nullable();
            $table->foreignId('group')->nullable()->constrained('groups');
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
