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
        Schema::create('relationships', function (Blueprint $table) {
            $table->bigIncrements('id'); // PRIMARY KEY
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('child_id');
            $table->timestamps();

            // Indexes
            $table->index('created_by');
            $table->index('parent_id');
            $table->index('child_id');

            // Foreign key constraints 
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('child_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
