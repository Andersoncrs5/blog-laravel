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
        Schema::create('user_metric', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger("likes_given_count_in_comment");
            $table->bigInteger("dislikes_given_count_in_comment");
            $table->bigInteger("likes_given_count_in_post");
            $table->bigInteger("deslikes_given_count_in_post");
            $table->bigInteger("followers_count");
            $table->bigInteger("following_count");
            $table->bigInteger("posts_count");
            $table->bigInteger("comments_count");
            $table->bigInteger("shares_count");
            $table->bigInteger("reports_received_count");
            $table->bigInteger("media_uploads_count");
            $table->bigInteger("saved_posts_count");
            $table->bigInteger("saved_comments_count");
            $table->bigInteger("saved_media_count");
            $table->bigInteger("edited_count");
            $table->bigInteger("play_list_count");
            $table->bigInteger("preference_count");
            $table->unsignedBigInteger('user_id')->unique();
        
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_metric');
    }
};
