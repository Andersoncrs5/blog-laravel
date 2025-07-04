<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('recover_password', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->string('email');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('expire_at')->nullable();
            $table->enum('status', ['pending', 'complete'])->default('pending');
            $table->unsignedBigInteger('user_id')->unique();
        
            $table->foreign('user_id')->references('id')->on('user')->onDelete('restrict');
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('recover_password');
    }
};
