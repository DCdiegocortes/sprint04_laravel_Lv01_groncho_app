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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 150);
            $table->string('description', 255)->nullable();
            $table->enum('item_condition', ['NEW', 'EXCELLENT', 'GOOD', 'FAIR'])->default('GOOD');
            $table->string('size', 100)->nullable();
            $table->enum('type', ['CLOTHES', 'ACCESSORIES']);
            $table->enum('offer_type', ['TRADE', 'GIFT', 'BOTH'])->default('TRADE');
            $table->enum('status', ['AVAILABLE', 'RESERVED', 'EXCHANGED', 'GIFTED'])->default('AVAILABLE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
