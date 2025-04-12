<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name', 150);
            $table->string('email', 250)->unique();
            $table->string('password');
            $table->boolean('is_adm')->default(false);
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
