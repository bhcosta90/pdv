<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('register_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id');
            $table->unsignedBigInteger('value')->nullable();
            $table->unsignedTinyInteger('action');
            $table->unsignedTinyInteger('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('register_histories');
    }
};
