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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('duration')->nullable();
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->text('include')->nullable();
            $table->text('exclude')->nullable();
            $table->string('category')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
