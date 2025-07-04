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
            $table->bigInteger("likes_given_count_in_comment")->default(0);
            $table->bigInteger("dislikes_given_count_in_comment")->default(0);
            $table->bigInteger("likes_given_count_in_post")->default(0);
            $table->bigInteger("deslikes_given_count_in_post")->default(0);
            $table->bigInteger("followers_count")->default(0);
            $table->bigInteger("following_count")->default(0);
            $table->bigInteger("posts_count")->default(0);
            $table->bigInteger("comments_count")->default(0);
            $table->bigInteger("shares_count")->default(0);
            $table->bigInteger("reports_received_count")->default(0);
            $table->bigInteger("media_uploads_count")->default(0);
            $table->bigInteger("saved_posts_count")->default(0);
            $table->bigInteger("saved_comments_count")->default(0);
            $table->bigInteger("saved_media_count")->default(0);
            $table->bigInteger("edited_count")->default(0);
            $table->bigInteger("play_list_count")->default(0);
            $table->bigInteger("preference_count")->default(0);
            $table->unsignedBigInteger('user_id')->unique();
        
            $table->foreign('user_id')->references('id')->on('user')->onDelete('restrict');
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
