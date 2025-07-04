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
        Schema::create('posts_metric', function (Blueprint $table) {
            $table->id();
            $table->uuid('post_id');
            $table->bigInteger("likes")->default(0);
            $table->bigInteger("dislikes")->default(0);
            $table->bigInteger("comments_count")->default(0);
            $table->bigInteger("shares_count")->default(0);
            $table->bigInteger("favorite_count")->default(0);
            $table->bigInteger("viewed_count")->default(0);
            $table->bigInteger("reports_received_count")->default(0);
            $table->bigInteger("media_count")->default(0);
            $table->bigInteger("edited_count")->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_metric');
    }
};
