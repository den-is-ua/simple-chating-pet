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
        Schema::create('chat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('sender_id')->unsigned();
            $table->bigInteger('recipient_id')->unsigned();
            $table->text('last_message');
            $table->timestamp('sent_at');
            $table->timestamp('deleted_at');
            $table->timestamps();
            
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('recipient_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
