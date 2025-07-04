<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('follower_id');
            $table->unsignedBigInteger('followed_id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        
            $table->foreign('follower_id')->references('id')->on('user')->onDelete('restrict');
            $table->foreign('followed_id')->references('id')->on('user')->onDelete('restrict');
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
