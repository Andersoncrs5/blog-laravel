<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorite_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->uuid('post_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('restrict');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('restrict');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('favorite_posts');
    }
};
