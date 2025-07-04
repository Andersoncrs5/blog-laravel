<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('content');
            $table->unsignedBigInteger('user_id');
            $table->uuid('post_id');
            $table->uuid('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        
            $table->foreign('user_id')->references('id')->on('user')->onDelete('restrict');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('restrict');
        });
        
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
        
        
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
