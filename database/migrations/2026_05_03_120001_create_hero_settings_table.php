<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title_top')->default('ВКЛЮЧАЕМ');
            $table->string('title_middle')->default('БЛОГЕРОВ');
            $table->string('title_bottom_prefix')->default('В ВАШИ');
            $table->string('title_accent')->default('ПРОДАЖИ');
            $table->text('description')->nullable();
            $table->json('stats')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_settings');
    }
};
