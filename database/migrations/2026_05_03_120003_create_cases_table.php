<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('brand');
            $table->string('category');           // "Спортивная обувь · 2025"
            $table->text('problem');
            $table->text('solution');
            $table->json('solution_paragraphs');   // accordion content (array of strings)
            $table->json('platforms');             // array of strings
            $table->json('audience');              // array of strings

            // Authors breakdown
            $table->unsignedInteger('authors_total')->default(0);
            $table->unsignedInteger('authors_micro')->default(0);
            $table->unsignedInteger('authors_mid')->default(0);
            $table->unsignedInteger('authors_top')->default(0);

            // Client
            $table->string('client_name');
            $table->string('client_role');
            $table->string('client_initials', 4);
            $table->string('client_photo')->nullable();   // optional uploaded image
            $table->text('testimonial');

            // Video
            $table->string('video_url');
            $table->string('video_thumbnail')->nullable(); // optional override; otherwise auto from YouTube
            $table->string('video_brand')->nullable();
            $table->string('video_author')->nullable();
            $table->string('video_views')->nullable();
            $table->string('video_date')->nullable();      // freeform string like "12.04.2026"

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
