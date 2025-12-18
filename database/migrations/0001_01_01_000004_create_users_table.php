<?php

use App\RolesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $roles = RolesEnum::cases();
        $role_id = array_find_key($roles, function ($value) {
            return $value === RolesEnum::USER;
        });

        Schema::table('users', function (Blueprint $table) use ($role_id) {
            $table->foreignId('role_id')->index()->default($role_id);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
