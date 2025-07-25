<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->string('reason', 250);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        
            $table->foreign('user_id')->references('id')->on('user')->onDelete('restrict');
            $table->foreign('sender_id')->references('id')->on('user')->onDelete('set null');
        });                
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
