<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained();
            $table->string('code');
            $table->string('name');
            $table->unsignedBigInteger('balance')->default(0);
            $table->foreignId('opened_by')->nullable()->constrained('users');
            $table->dateTime('opened_at')->nullable();
            $table->unsignedTinyInteger('opened_attempt')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users');
            $table->dateTime('closed_at')->nullable();
            $table->unsignedTinyInteger('closed_attempt')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['store_id', 'code']);
            $table->unique(['store_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
