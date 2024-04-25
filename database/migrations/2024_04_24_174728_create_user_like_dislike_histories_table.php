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
        Schema::create('user_like_dislike_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('like_from_user')->constrained(table: 'users', indexName: 'like_from_user')->onDelete('cascade'); // like by this user
            $table->foreignId('like_to_user')->constrained(table: 'users', indexName: 'like_to_user')->onDelete('cascade'); // like to this user
            $table->integer('status')->comment('0 = dislike, 1=like');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_like_dislike_histories');
    }
};
